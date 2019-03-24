import { render } from "react-dom";
import App from './components/App';

const container = document.getElementById('app');

render(
    <App
        basePath={container.dataset.basePath}
        initialStacks={JSON.parse(container.dataset.initialStacks)}
    />,
    container
);
