<?php

namespace App\Http\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission('documents.documents.upload') ?? false;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:20480', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,webp'],
            'category' => ['required', 'string', 'max:120'],
            'title_ar' => ['required', 'string', 'max:190'],
            'title_en' => ['nullable', 'string', 'max:190'],
            'linkable_type' => ['nullable', 'string', 'max:120'],
            'linkable_id' => ['nullable', 'integer'],
            'retention_until' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
        ];
    }
}
