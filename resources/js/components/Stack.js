import { useEffect, useState } from "react";

export default function Stack({ uuid }) {
    const [newLink, setNewLink] = useState("");
    const [links, setLinks] = useState([]);

    useEffect(() => {
        fetch(`/api/links?filter[stack_uuid]=${uuid}`)
            .then(res => res.json())
            .then(res => setLinks(res.data));

        window.Echo.private(`stacks.${uuid}`).listen(".title_fetched", ({ link_uuid, title }) => {
            setLinks(links =>
                links.map(link => {
                    if (link.uuid !== link_uuid) {
                        return link;
                    }

                    return { ...link, title };
                })
            );
        });

        return () => window.Echo.leaveChannel(`.stacks.${uuid}`);
    }, [uuid]);

    function saveLink(e) {
        e.preventDefault();

        fetch("/api/links", {
            method: "POST",
            body: JSON.stringify({ url: newLink }),
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest"
            }
        })
            .then(res => res.json())
            .then(link => {
                setLinks([link, ...links]);
                setNewLink("");
            });
    }

    return (
        <>
            <form className="w-full flex border-b border-gray-200" onSubmit={saveLink}>
                <input
                    type="text"
                    value={newLink}
                    onChange={e => setNewLink(e.target.value)}
                    className="flex-1 px-3 focus:outline-none"
                    placeholder="https://pushtostack.app"
                />
                <button className="px-3 py-2">Push</button>
            </form>
            <ul>
                {links.map(link => (
                    <li key={link.uuid}>
                        <a
                            className="block px-3 py-2 border-b border-gray-200"
                            href={link.url}
                            target="_blank"
                            rel="nofollow"
                        >
                            {link.title} <span className="inline-block text-gray-600">– {link.domain}</span>
                        </a>
                    </li>
                ))}
            </ul>
        </>
    );
}
