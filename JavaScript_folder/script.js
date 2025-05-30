window.onscroll = function() {
  if (window.scrollY > window.innerHeight) { 
    document.body.classList.add('scrolled'); 
  } else {
    document.body.classList.remove('scrolled'); 
  }
};
