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
            {/* <form className="w-full flex" onSubmit={saveLink}>
                <input
                    type="text"
                    value={newLink}
                    onChange={e => setNewLink(e.target.value)}
                    className="flex-1 px-3 focus:outline-none"
                    placeholder="https://pushtostack.app"
                />
                <button className="px-3 py-2">Push</button>
            </form> */}
            <ul>
                {links.map(link => (
                    <li key={link.uuid}>
                        <a className="block pl-6 py-2" href={link.url} target="_blank" rel="nofollow">
                            <span
                                className="inline-block w-5 h-5 bg-gray-300 rounded mr-3"
                                style={{ transform: "translateY(0.225em)" }}
                            />
                            <span className="font-medium text-gray-900">{link.title}</span>{" "}
                            <span className="inline-block text-gray-600"> – {link.domain}</span>
                        </a>
                    </li>
                ))}
            </ul>
        </>
    );
}
