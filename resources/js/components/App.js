import { useEffect, useState } from "react";

export default function App({ basePath, initialStacks }) {
    const [links, setLinks] = useState([]);
    const [selectedStackUuid, setSelectedStackUuid] = useState(initialStacks[0].uuid);

    useEffect(() => {
        fetch(`/api/links?filter[stack_uuid]=${selectedStackUuid}`)
            .then(res => res.json())
            .then(res => setLinks(res.data));
    }, [selectedStackUuid]);

    return <div>
        <ul>
            {initialStacks.map(stack => (
                <li key={stack.uuid}>
                    <button
                        className={stack.uuid === selectedStackUuid ? 'font-bold' : ''}
                        onClick={() => setSelectedStackUuid(stack.uuid)}
                    >
                        {stack.name} ({stack.link_count})
                    </button>
                </li>
            ))}
        </ul>
        <ul>
            {links.map(link => (
                <li key={link.uuid}>{link.title} - {link.url}</li>
            ))}
        </ul>
    </div>
}
