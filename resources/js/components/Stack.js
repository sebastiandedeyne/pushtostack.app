import { useEffect, useState } from "react";

export default function Stack({ uuid }) {
    const [newLinks, setNewLinks] = useState(["https://spatie.be"]);
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
            body: JSON.stringify({ url: newLinks[0] }),
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest"
            }
        })
            .then(res => res.json())
            .then(link => {
                setLinks([link, ...links]);
                setNewLinks(["https://spatie.be"]);
            });
    }

    return (
        <ul>
            <li>
                <form className="w-full flex pl-6 py-2" onSubmit={saveLink}>
                    <span className="w-5 h-5 bg-gray-300 rounded mr-3" style={{ transform: "translateY(0.225em)" }} />
                    <input
                        type="text"
                        value={newLinks[0]}
                        onChange={e => setNewLinks([e.target.value])}
                        className="flex-1 font-medium focus:outline-none"
                        style={{ transform: "translateY(0.075em)" }}
                        placeholder="Paste an URL..."
                    />
                </form>
            </li>
            {links.map(link => (
                <li key={link.uuid}>
                    <a className="block pl-6 py-2" href={link.url} target="_blank" rel="nofollow">
                        {link.favicon_url ? (
                            <img
                                src={link.favicon_url}
                                alt={`Favicon for ${link.title}`}
                                className="inline-block w-5 h-5 rounded mr-3"
                            />
                        ) : (
                            <span
                                className="inline-block w-5 h-5 bg-gray-300 rounded mr-3"
                                style={{ transform: "translateY(0.225em)" }}
                            />
                        )}
                        <span className="font-medium text-gray-900">{link.title}</span>{" "}
                        <span className="inline-block text-gray-600"> – {link.domain}</span>
                    </a>
                </li>
            ))}
        </ul>
    );
}
