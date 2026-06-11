import { Badge } from "@/components/ui/badge";
import { Card, CardContent } from "@/components/ui/card";

export function MetricCard({
  label,
  value,
  trend
}: {
  label: string;
  value: string;
  trend?: string;
}) {
  return (
    <Card>
      <CardContent className="space-y-3">
        <div className="text-sm font-medium text-muted-foreground">{label}</div>
        <div className="text-2xl font-bold tracking-normal">{value}</div>
        {trend ? <Badge variant="success">{trend}</Badge> : null}
      </CardContent>
    </Card>
  );
}
