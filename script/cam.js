var video = document.querySelector('video');
var canvas = document.querySelector('canvas');
var preview = document.getElementById('preview');
var photo = document.getElementById('photo');
var save = document.getElementById('save_link');
var width = 200;
var height = 200;
var img;
var test = new Image();
var cadre = false;

test.src = "cadre.gif";

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
    if (cadre)
        canvas.getContext('2d').drawImage(test, 0, 0, width, height);
    img = canvas.toDataURL('image/png');
    save.setAttribute('value', img);

}

function draw_cam() {
    preview.getContext('2d').drawImage(video, 0, 0, width, height);
    if (cadre)
        preview.getContext('2d').drawImage(test, 0, 0, width, height);
    setTimeout(draw_cam, 0);
}

function change_cadre() {
    if (cadre)
        cadre = false;
    else
        cadre = true;
}
