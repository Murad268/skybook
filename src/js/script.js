const statuses = () => {
   const main = document.querySelector(".main__statuses");
   const mainStatus = document.querySelectorAll(".main__status")
   const margin = window.getComputedStyle(document.querySelector(".main__status")).marginRight;
   const main__statusWidth = document.querySelector(".main__status").clientWidth;
   const butttonLeft = document.querySelector(".left");
   const butttonRight = document.querySelector(".right");
   const mainWidth = +mainStatus.length*(parseFloat(margin)+main__statusWidth);

   let offset = 0;

   function righting() {
      if(offset!==(mainWidth-(parseFloat(margin)+main__statusWidth))) {
         offset+=+main__statusWidth + parseFloat(margin)
      } else {
         offset=0
      }
 
      main.style.transform =`translateX(-${offset}px)`
   }
   function lefting() {
      if(offset!==0) {
         offset-=main__statusWidth+parseFloat(margin)
        
      } else {
         offset=(mainWidth-(parseFloat(margin)+main__statusWidth))
      }

      main.style.transform =`translateX(-${offset}px)`
   }

   main.addEventListener("swiped-right", () => {
      righting()
   })
   main.addEventListener("swiped-left", () => {
      lefting()
   })
   butttonRight.addEventListener("click", () => {
      righting()
   })
   butttonLeft.addEventListener("click", () => {
      lefting()
   })
}
statuses()