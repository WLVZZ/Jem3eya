<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Documents\DocumentUploadRequest;
use App\Models\Document;
use App\Models\DocumentVersion;
use App\Services\Audit\AuditLogger;
use App\Services\Storage\SecureUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DocumentController extends Controller
{
    public function __construct(
        private readonly SecureUploadService $uploads,
        private readonly AuditLogger $audit,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json(Document::query()
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->latest('id')
            ->paginate((int) $request->input('per_page', 20)));
    }

    public function store(DocumentUploadRequest $request): JsonResponse
    {
        $stored = $this->uploads->store($request->file('file'), 'documents');

        $document = Document::create([
            ...$request->safe()->except('file'),
            ...$stored,
            'uploaded_by' => $request->user()->id,
            'version' => 1,
            'ocr_status' => 'pending',
            'search_status' => 'pending',
        ]);

        DocumentVersion::create([
            'document_id' => $document->id,
            'version' => 1,
            'disk' => $stored['disk'],
            'path' => $stored['path'],
            'checksum' => $stored['checksum'],
            'uploaded_by' => $request->user()->id,
        ]);

        $this->audit->record('upload', $document, ['module' => 'documents'], $request);

        return response()->json($document, 201);
    }

    public function show(Document $document): JsonResponse
    {
        return response()->json($document->load('versions'));
    }
}
