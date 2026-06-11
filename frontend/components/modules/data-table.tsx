import type * as React from "react";
import { Table, Td, Th } from "@/components/ui/table";

export function DataTable({
  columns,
  rows
}: {
  columns: Array<{ key: string; label: string }>;
  rows: Array<Record<string, React.ReactNode>>;
}) {
  return (
    <div className="overflow-x-auto rounded-lg border">
      <Table>
        <thead>
          <tr>{columns.map((column) => <Th key={String(column.key)}>{column.label}</Th>)}</tr>
        </thead>
        <tbody>
          {rows.map((row, index) => (
            <tr key={index} className="hover:bg-muted/40">
              {columns.map((column) => <Td key={column.key}>{row[column.key] ?? ""}</Td>)}
            </tr>
          ))}
        </tbody>
      </Table>
    </div>
  );
}
