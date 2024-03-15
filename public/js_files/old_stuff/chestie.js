function getRandomColor() {
    color = "hsl(" + Math.random() * 360 + ", 100%, 75%)";
    return color;
}

function hslToHex(h, s, l) {
    h /= 360;
    s /= 100;
    l /= 100;
    let r, g, b;
    if (s === 0) {
        r = g = b = l; // achromatic
    } else {
        const hue2rgb = (p, q, t) => {
            if (t < 0) t += 1;
            if (t > 1) t -= 1;
            if (t < 1 / 6) return p + (q - p) * 6 * t;
            if (t < 1 / 2) return q;
            if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
            return p;
        };
        const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        const p = 2 * l - q;
        r = hue2rgb(p, q, h + 1 / 3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1 / 3);
    }
    const toHex = (x) => {
        const hex = Math.round(x * 255).toString(16);
        return hex.length === 1 ? "0" + hex : hex;
    };
    return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
}

document.getElementById("player").focus();

document.getElementById("player").addEventListener("keyup", function (event) {
    if (event.code === "ArrowUp") addPlayerToList();
});

function addPlayerToList() {
    var ul = document.getElementById("players-list");
    var player = document.getElementById("player");
    var li = document.createElement("li");

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "players[]";
    input.value = player.value;

    if (!player.value) console.log("please fill ur name");
    else {
        li.setAttribute("name", "player_" + player_count);
        li.appendChild(document.createTextNode(player.value));
        li.setAttribute("style", "max-width: 400px");

        var color_options = document.createElement("input");
        color_options.setAttribute("name", "player_" + player_count + "_color");
        color_options.setAttribute("type", "color");
        color_options.setAttribute(
            "value",
            hslToHex(Math.random() * 360, 100, 75)
        );
        color_options.setAttribute("style", "float: right");

        li.appendChild(color_options);

        ul.appendChild(li);
        ul.appendChild(input);

        players.push(player.value);
        player.value = "";

        player_count++;

        console.log(players);
    }
}

function removePlayerFromList() {
    var ul = document.getElementById("players-list");

    ul.removeChild(ul.lastElementChild);
    players.pop();
    player_count--;
}
