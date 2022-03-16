console.log('I exist!');

var images = {
   "@maxImageDimension": "800",
   "@textColor": "0xFFFFFF",
   "@frameColor": "0xFFFFFF",
   "@bgColor": "0x181818",
   "@frameWidth": "20",
   "@stagePadding": "20",
   "@thumbnailColumns": "2",
   "@thumbnailRows": "5",
   "@navPosition": "right",
   "@navDirection": "LTR",
   "@title": "monuments",
   "image": [
      {
         "name": "IMG_2101.JPG",
         "caption": "IMG_2101"
      },
      {
         "name": "IMG_2102.JPG",
         "caption": "IMG_2102"
      },
      {
         "name": "IMG_2105.JPG",
         "caption": "IMG_2105"
      },
      {
         "name": "IMG_2106.JPG",
         "caption": "IMG_2106"
      },
      {
         "name": "IMG_2160.JPG",
         "caption": "IMG_2160"
      },
      {
         "name": "IMG_2161.JPG",
         "caption": "IMG_2161"
      },
      {
         "name": "IMG_2162.JPG",
         "caption": "IMG_2162"
      },
      {
         "name": "IMG_2163.JPG",
         "caption": "IMG_2163"
      },
      {
         "name": "IMG_2164.JPG",
         "caption": "IMG_2164"
      },
      {
         "name": "IMG_2165.JPG",
         "caption": "IMG_2165"
      },
      {
         "name": "IMG_2166.JPG",
         "caption": "IMG_2166"
      },
      {
         "name": "IMG_2167.JPG",
         "caption": "IMG_2167"
      },
      {
         "name": "IMG_2168.JPG",
         "caption": "IMG_2168"
      },
      {
         "name": "IMG_2169.JPG",
         "caption": "IMG_2169"
      },
      {
         "name": "IMG_2170.JPG",
         "caption": "IMG_2170"
      },
      {
         "name": "IMG_2171.JPG",
         "caption": "IMG_2171"
      },
      {
         "name": "IMG_2172.JPG",
         "caption": "IMG_2172"
      },
      {
         "name": "IMG_2259.JPG",
         "caption": "IMG_2259"
      },
      {
         "name": "IMG_2260.JPG",
         "caption": "IMG_2260"
      },
      {
         "name": "IMG_2261.JPG",
         "caption": "IMG_2261"
      },
      {
         "name": "IMG_2262.JPG",
         "caption": "IMG_2262"
      },
      {
         "name": "IMG_2263.JPG",
         "caption": "IMG_2263"
      },
      {
         "name": "IMG_2264.JPG",
         "caption": "IMG_2264"
      },
      {
         "name": "IMG_2265.JPG",
         "caption": "IMG_2265"
      }
   ]
}

console.log(images); // to see the object
console.log(images.image.length);   to see the length of the array
console.log(images.image[0].name);  to display the first image name

//Loop through every image
for (var i = 0; i < images.image.length; i++) {
   console.log(images.image[i].name);
}