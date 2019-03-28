import { useState } from "react";
import Stack from "./Stack";

export default function App({ initialStacks }) {
    const [stacks, setStacks] = useState(initialStacks);
    const [selectedStackUuid, setSelectedStackUuid] = useState(initialStacks[0].uuid);

    function updateStack(newStack) {
        setStacks(stacks => {
            return stacks.map(stack => {
                if (stack.uuid === newStack.uuid) {
                    return newStack;
                }

                return stack;
            });
        });
    }

    return (
        <div className="w-full h-screen flex">
            <nav className="w-1/5 py-3 px-3 bg-gray-100 border-r border-gray-200">
                <ul>
                    {stacks.map(stack => (
                        <li key={stack.uuid}>
                            <a
                                href="#"
                                className={`flex items-center justify-between px-3 py-2 mb-1 rounded ${
                                    stack.uuid === selectedStackUuid ? "text-blue-600 bg-gray-200" : "text-gray-700"
                                }`}
                                onClick={e => (e.preventDefault(), setSelectedStackUuid(stack.uuid))}
                            >
                                <span className="font-semibold">{stack.name}</span>{" "}
                                <span className="text-sm text-gray-600">{stack.link_count}</span>
                            </a>
                        </li>
                    ))}
                </ul>
            </nav>
            <div className="flex-1 py-2">
                <Stack uuid={selectedStackUuid} onUpdate={updateStack} />
            </div>
        </div>
    );
}
