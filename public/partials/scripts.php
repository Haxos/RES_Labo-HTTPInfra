<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/transactions.js"></script>
<script src="/assets/js/smooth-scroll.js"></script>
<script src="/assets/js/particles.min.js"></script>

<script>
    $(document).ready(function() {
        new SmoothScroll().watch();

        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 50,
                },
                "opacity": {
                    "value": 0.4,
                },
                "size": {
                    "value": 3,
                },
                "line_linked": {
                    "enable": true,
                    "distance": 175,
                    "opacity": 0.25,
                },
                "move": {
                    "enable": true,
                    "speed": 3,
                }
            },
            "interactivity": {
                "events": {
                    "onclick": {
                        "enable": false,
                    }
                }
            }
        });
    });
</script>
