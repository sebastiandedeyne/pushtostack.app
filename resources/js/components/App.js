import { useEffect, useState } from "react";
import Stack from "./Stack";

export default function App({ basePath, initialStacks }) {
    const [selectedStackUuid, setSelectedStackUuid] = useState(initialStacks[0].uuid);

    return (
        <div className="w-full h-screen flex">
            <nav className="w-1/5 bg-gray-200 border-r">
                <ul>
                    {initialStacks.map(stack => (
                        <li key={stack.uuid}>
                            <a
                                href="#"
                                className={`flex items-center justify-between px-4 p-2 ${
                                    stack.uuid === selectedStackUuid ? "text-white bg-blue-500" : "text-gray-600"
                                }`}
                                onClick={e => (e.preventDefault(), setSelectedStackUuid(stack.uuid))}
                            >
                                {stack.name}{" "}
                                <span className={`text-xs ${stack.uuid === selectedStackUuid ? "" : "text-gray-500"}`}>
                                    {stack.link_count}
                                </span>
                            </a>
                        </li>
                    ))}
                </ul>
            </nav>
            <div className="flex-1">
                <Stack uuid={selectedStackUuid} />
            </div>
        </div>
    );
}
