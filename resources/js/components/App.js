export default function App({ basePath, initialStacks }) {
    return <div>
        <ul>
            {initialStacks.map(stack => (
                <li key={stack.uuid}>{stack.name}</li>
            ))}
        </ul>
    </div>
}
