
gsap.registerPlugin(ScrollTrigger);

gsap.utils.toArray('.fade-in-up').forEach((el) => {
  gsap.fromTo(
    el,
    {
      y: 150,
      opacity: 0
    },
    {
      y: 0,
      opacity: 1,
      duration: 1,
      ease: 'back.out(1.7)',
      scrollTrigger: {
        trigger: el,
        start: 'top 80%',
        end: 'top 0%',
        toggleActions: 'play reverse play reverse',
        // markers: true
      }
    }
  );
});

gsap.utils.toArray('.fade-in-up-footer').forEach((el) => {
  gsap.fromTo(
    el,
    {
      y: 150,
      opacity: 0
    },
    {
      y: 0,
      opacity: 1,
      duration: 1,
      ease: 'back.out(1.7)',
      scrollTrigger: {
        trigger: el,
        start: 'top 100%',
        end: 'top 0%',
        toggleActions: 'play reverse play reverse',
        // markers: true
      }
    }
  );
});

// $(document).ready(function () {
    // setTimeout(() => {

        gsap.utils.toArray('.fade-in-scale-up').forEach((el) => {
          gsap.fromTo(
            el,
            {
              y: 0,
              scale: 0.5,
              opacity: 0
            },
            {
              y: 0,
              scale: 1,
              opacity: 1,
              duration: 1,
              ease: 'back.out(1.7)',
              scrollTrigger: {
                trigger: el,
                start: 'top 80%',
                end: 'top 0%',
                toggleActions: 'play reverse play reverse',
                // markers: true
              }
            }
          );
        });

        gsap.utils.toArray('.fade-in-left').forEach((el) => {
          gsap.fromTo(
            el,
            {
              x: '-5vw',
              scale: 1,
              opacity: 0
            },
            {
              x: 0,
              scale: 1,
              opacity: 1,
              duration: 1,
              ease: 'back.out(1.7)',
              scrollTrigger: {
                trigger: el,
                start: 'top 80%',
                end: 'top 0%',
                toggleActions: 'play reverse play reverse',
                // markers: true
              }
            }
          );
        });

    // }, 500)

// });

gsap.utils.toArray('.heart').forEach((el, i) => {

  const section = el.closest('section');
  if (!section) return;

  gsap.fromTo(
    el,
    { y: -100 },
    {
      y: 100,
      ease: 'none',
      scrollTrigger: {
        trigger: section,         // ✅ correct section
        start: 'top bottom',
        end: 'bottom top',
        scrub: 1,
        // markers: true
      }
    }
  );

});

gsap.utils.toArray('.heart').forEach((el, i) => {

  const section = el.closest('div');
  if (!section) return;

  gsap.fromTo(
    el,
    { y: -100 },
    {
      y: 100,
      ease: 'none',
      scrollTrigger: {
        trigger: section,         // ✅ correct section
        start: 'top bottom',
        end: 'bottom top',
        scrub: 1,
        // markers: true
      }
    }
  );

});

gsap.utils.toArray('.heart').forEach((el, i) => {

  const section = el.closest('footer');
  if (!section) return;

  gsap.fromTo(
    el,
    { y: -100 },
    {
      y: 100,
      ease: 'none',
      scrollTrigger: {
        trigger: section,         // ✅ correct section
        start: 'top bottom',
        end: 'bottom top',
        scrub: 1,
        // markers: true
      }
    }
  );

});