/**
 * CIPCard Platform - GSAP ScrollTrigger 3D & Parallax Engine
 */

document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('GSAP or ScrollTrigger not loaded.');
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    const card3D = document.querySelector('#hero-3d-card');
    const heroSection = document.querySelector('#hero');
    const phoneMockup = document.querySelector('#phone-mockup');
    const phoneScreen = document.querySelector('#phone-screen');
    const floatingNfc = document.querySelector('#floating-nfc-icon');
    const floatingWaves = document.querySelector('#floating-waves');
    const floatingSocial1 = document.querySelector('#floating-social-1');
    const floatingSocial2 = document.querySelector('#floating-social-2');

    if (!card3D || !heroSection) return;

    // Initial Hero Entrance Animation
    gsap.from('#hero-headline', {
        y: 40,
        opacity: 0,
        duration: 1.2,
        ease: 'power3.out'
    });

    gsap.from('#hero-subtext', {
        y: 30,
        opacity: 0,
        duration: 1.2,
        delay: 0.2,
        ease: 'power3.out'
    });

    gsap.from('#hero-cta-box', {
        y: 20,
        opacity: 0,
        duration: 1,
        delay: 0.4,
        ease: 'power3.out'
    });

    gsap.from(card3D, {
        scale: 0.8,
        rotateY: -45,
        rotateX: 25,
        opacity: 0,
        duration: 1.6,
        delay: 0.3,
        ease: 'elastic.out(1, 0.75)'
    });

    // Interactive Mouse Tilt on Hero Card
    heroSection.addEventListener('mousemove', (e) => {
        const rect = heroSection.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width - 0.5;
        const y = (e.clientY - rect.top) / rect.height - 0.5;

        gsap.to(card3D, {
            rotateY: x * 25,
            rotateX: -y * 25,
            ease: 'power2.out',
            duration: 0.6
        });

        if (floatingNfc) {
            gsap.to(floatingNfc, {
                x: x * 35,
                y: y * 35,
                duration: 0.5
            });
        }
        if (floatingSocial1) {
            gsap.to(floatingSocial1, {
                x: -x * 30,
                y: -y * 30,
                duration: 0.6
            });
        }
        if (floatingSocial2) {
            gsap.to(floatingSocial2, {
                x: x * 45,
                y: y * 25,
                duration: 0.7
            });
        }
    });

    heroSection.addEventListener('mouseleave', () => {
        gsap.to(card3D, {
            rotateY: 0,
            rotateX: 0,
            ease: 'power2.out',
            duration: 0.8
        });
        if (floatingNfc) gsap.to(floatingNfc, { x: 0, y: 0, duration: 0.8 });
        if (floatingSocial1) gsap.to(floatingSocial1, { x: 0, y: 0, duration: 0.8 });
        if (floatingSocial2) gsap.to(floatingSocial2, { x: 0, y: 0, duration: 0.8 });
    });

    // ScrollTrigger: 3D Card move towards Phone Mockup
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: '#hero',
            start: 'top top',
            end: '+=150%',
            scrub: 1.2,
            pin: true,
            anticipatePin: 1
        }
    });

    // 1. Rotate & move card towards phone
    tl.to(card3D, {
        scale: 0.65,
        rotateY: 20,
        rotateX: -10,
        x: '-25%',
        y: '10%',
        duration: 2
    })
    // 2. Parallax elements move outward with depth
    .to(floatingNfc, {
        scale: 1.5,
        opacity: 0,
        y: '-100px',
        duration: 1.5
    }, 0)
    .to(floatingSocial1, {
        x: '-80px',
        opacity: 0,
        duration: 1.5
    }, 0)
    .to(floatingSocial2, {
        x: '80px',
        opacity: 0,
        duration: 1.5
    }, 0)
    // 3. Bring card to tap contact with phone
    .to(card3D, {
        x: '-12%',
        y: '5%',
        rotateZ: -5,
        duration: 1
    })
    // 4. Trigger NFC contact pulse
    .to(floatingWaves, {
        scale: 2,
        opacity: 1,
        duration: 0.5
    })
    // 5. Phone screen lights up with profile
    .to(phoneScreen, {
        opacity: 1,
        scale: 1,
        duration: 1.2,
        ease: 'power2.out'
    });

    // Reveal animations for feature cards
    gsap.utils.toArray('.feature-card').forEach((card) => {
        gsap.from(card, {
            scrollTrigger: {
                trigger: card,
                start: 'top 85%'
            },
            y: 50,
            opacity: 0,
            duration: 0.8,
            ease: 'power3.out'
        });
    });
});
