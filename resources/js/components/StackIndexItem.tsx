import * as React from "react";
import { Stack } from "../index.d";

type Props = Stack & {
  active: boolean;
  onClick: () => void;
  className?: string;
};

export default function StackIndexItem({
  name,
  link_count,
  active,
  onClick,
  className = ""
}: Props) {
  return (
    <li>
      <a
        href="#"
        className={`flex items-center justify-between px-3 py-2 mb-1 rounded ${className} ${
          active ? "text-blue-600 bg-gray-200" : "text-gray-700"
        }`}
        onClick={onClick}
      >
        <span className="font-semibold">{name}</span>{" "}
        <span className="text-sm text-gray-600">{link_count}</span>
      </a>
    </li>
  );
}
