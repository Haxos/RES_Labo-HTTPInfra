function SmoothScroll()
{
    var SCROLL_OFFSET = 0;
    var SCROLL_DURATION = 400;

    var self = this;

    //
    // Public members
    //
    self.watch = watchClicks;
    self.to = scrollTo;

    //
    // Functions
    //
    function watchClicks()
    {
        $(document).on('click', 'a[href*="#"]', function (event) {
            var url = event.target.href;

            if (!isSamePage(url))
                return;

            scrollTo(url.substr(url.indexOf('#')));
        });
    }

    function scrollTo(element)
    {
        var $element = $(element);

        if ($element.length === 0) {
            return;
        }

        $('html, body').animate({
            scrollTop: $element.offset().top - SCROLL_OFFSET
        }, SCROLL_DURATION);
    }

    function isSamePage(url)
    {
        var node = document.createElement('a');
        node.href = url;

        return (
            node.host === window.location.host &&
            node.pathname === window.location.pathname
        );
    }
}
