let video = document.querySelector('video');
let canvas = document.querySelector('canvas');
let preview = document.getElementById('preview');
let photo = document.getElementById('photo');
let width = 200;
let height = 200;
let img;
let id_cadre = new Image();
let cadre = 0;
let x_cadre = 0;
let y_cadre = 0;

navigator.getMedia = navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia;

navigator.getMedia(
    {
        video: true,
        audio: false
    },
    function (stream) {
        if (navigator.mozGetUserMedia)
            video.mozSrcObject = stream;
        else 
        {
            var vendorURL = window.URL || window.webkitURL;
            video.src = vendorURL.createObjectURL(stream);
        }
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        video.play();
    },
    function (err) {
        console.log("An error occured! " + err);
    }
);

canvas.setAttribute('with', width);
canvas.setAttribute('height', height);
preview.setAttribute('width', width);
preview.setAttribute('height', height);
draw_cam();

function picture() {
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    /*if (cadre)
        canvas.getContext('2d').drawImage(id_cadre, 0, 0, width, height);*/
    img = canvas.toDataURL('image/png');
    document.getElementById('save_link').setAttribute('value', img);
    document.getElementById('save_cadre').setAttribute('value', cadre);
    document.getElementById('save_x').setAttribute('value', x_cadre);
    document.getElementById('save_y').setAttribute('value', y_cadre);
}

function draw_cam() {
    preview.getContext('2d').drawImage(video, 0, 0, width, height);
    if (cadre != 0)
        preview.getContext('2d').drawImage(id_cadre, y_cadre, x_cadre, width, height);
    setTimeout(draw_cam, 0);
}

function change_cadre(id) {
    cadre = id;
    id_cadre.src = id + '.png';
    x_cadre = 0;
    y_cadre = 0;
}

function move(dir) {
    if (dir == 1)
        x_cadre -= 10;
    if (dir == 2)
        y_cadre -= 10;
    if (dir == 3)
        x_cadre += 10;
    if (dir == 4)
        y_cadre += 10;
}
