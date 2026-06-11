import type * as React from "react";
import { cn } from "@/lib/utils";

const variants = {
  default: "bg-muted text-foreground",
  success: "bg-success/10 text-success",
  warning: "bg-warning/10 text-warning",
  destructive: "bg-destructive/10 text-destructive"
};

export function Badge({
  className,
  variant = "default",
  ...props
}: React.HTMLAttributes<HTMLSpanElement> & { variant?: keyof typeof variants }) {
  return (
    <span
      className={cn("inline-flex rounded-md px-2 py-1 text-xs font-semibold", variants[variant], className)}
      {...props}
    />
  );
}
