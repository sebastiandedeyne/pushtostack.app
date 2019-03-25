import Echo from "laravel-echo";
import Pusher from "pusher-js";
import { render } from "react-dom";
import App from './components/App';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'f7082fa522418c67f533',
    cluster: 'eu',
    namespace: 'App.Events.Broadcast'
});

const container = document.getElementById('app');

render(
    <App
        basePath={container.dataset.basePath}
        initialStacks={JSON.parse(container.dataset.initialStacks)}
    />,
    container
);
