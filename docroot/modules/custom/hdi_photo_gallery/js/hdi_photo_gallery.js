// document.addEventListener('DOMContentLoaded', function () {
//   new Zooming({
//     bgColor: 'rgba(0, 57, 96, 0.75)'
//   }).listen('.photo-gallery img')
// })

new VenoBox({
  selector: ".gallery-image-link",
  fitView: true,
  overlayColor: 'rgba(0, 57, 96, 0.75)',
  spinner: 'circle',
  shareStyle: 'pill',
  share: true
});
