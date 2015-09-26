<?php
    define('JAVASCRIPT', true);
    require_once "../../includes/common.php";
    error_reporting(0);
    header("Content-Type: application/x-javascript");
?>
<!-- --><script>
        var obscura = {
            background: "<?php echo ( Config::current()->module_obscura["background"] ) ?>",
            spacing: Math.abs("<?php echo ( Config::current()->module_obscura["spacing"] ) ?>"),
            protect: <?php echo ( Config::current()->module_obscura["protect"] ? "true" : "false" ) ?>,
            active: false,
            styles: {
                fg: {
                    "display": "block",
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "width": "auto",
                    "height": "auto",
                    "visibility": "hidden"
                },
                bg: {
                    "position": "fixed",
                    "top": "0px",
                    "right": "0px",
                    "bottom": "0px",
                    "left": "0px",
                    "z-index": 2147483647,
                    "opacity": 0,
                    "transition-property": "opacity",
                    "transition-duration": "500ms",
                    "cursor": "wait"
                },
                image: {
                    "-webkit-tap-highlight-color": "rgba(0,0,0,0)",
                    "cursor": "url('<?php echo ( Config::current()->chyrp_url."/modules/obscura/images/zoom-in.svg") ?>'), pointer"
                },
                black: {
                    "background-color": "#000000"
                },
                grey: {
                    "background-color": "#3f3f3f"
                },
                white: {
                    "background-color": "#ffffff"
                },
                inherit: {
                    "background-color": "inherit"
                },
            },
            init: function() {
                if ( isNaN(obscura.spacing) ) obscura.spacing = 24;
                $.extend( obscura.styles.bg, obscura.styles[obscura.background] );
                $("img.image").not(".suppress_obscura").click(obscura.load).css(obscura.styles.image);
                if ( obscura.protect ) $("img.image").not(".suppress_obscura").on({ contextmenu: function() { return false } });
                $(window).on({ resize: obscura.hide, orientationchange: obscura.hide, popstate: obscura.hide });
                obscura.watch();
            },
            watch: function() {
                // Watch for DOM additions on blog pages
                if ( !!window.MutationObserver && $(".post").length ) {
                    var target = $(".post").last().parent()[0];
                    var observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            for (var i = 0; i < mutation.addedNodes.length; ++i) {
                                var item = mutation.addedNodes[i];
                                $(item).find("img.image").not(".suppress_obscura").click(obscura.load).css(obscura.styles.image);
                                if ( obscura.protect ) $(item).find("img.image").not(".suppress_obscura").on({ contextmenu: function() { return false } });
                            }
                        });
                    });
                    var config = { childList: true, subtree: true };
                    observer.observe(target, config);
                }
            },
            load: function() {
                if ( obscura.active == false ) {
                    var src = $(this).attr('src'), href = $(this).parent().attr('href'), alt = $(this).attr('alt');
                    $("<div>", {
                        "id": "obscura-bg",
                        "role": "img",
                        "aria-label": alt
                    }).css(obscura.styles.bg).click(obscura.hide).append($("<img>", {
                        "id": "obscura-fg",
                        "src": href || src, // Load original (Photo Feather)
                        "alt": alt
                    }).css(obscura.styles.fg).load(obscura.show).error(function() {
                        $(this).off('error'); this.src = src;
                    })).appendTo("body");
                    obscura.active = true;
                    return false;
                }
            },
            show: function() {
                var fg = $("#obscura-fg"), fgWidth = fg.outerWidth(), fgHeight = fg.outerHeight();
                var bg = $("#obscura-bg"), bgWidth = bg.outerWidth(), bgHeight = bg.outerHeight();
                if ( obscura.protect ) $(fg).on({ contextmenu: function() { return false } });
                while ( ( ( bgWidth - ( obscura.spacing * 2 ) ) < fgWidth ) || ( ( bgHeight - ( obscura.spacing * 2 ) ) < fgHeight ) ) {
                    Math.round(fgWidth = fgWidth * 0.99);
                    Math.round(fgHeight = fgHeight * 0.99);
                }
                fg.css({
                    "top": Math.round( ( bgHeight - fgHeight ) / 2 ) + 'px',
                    "left": Math.round( ( bgWidth - fgWidth ) / 2 ) + 'px',
                    "width": fgWidth + 'px',
                    "height": fgHeight + 'px',
                    "visibility": 'visible'
                });
                $("<img>", {
                    "src": "<?php echo ( Config::current()->chyrp_url."/modules/obscura/images/minimize.svg") ?>",
                    "alt": "<?php echo ( __("Minimize", "obscura") ) ?>",
                    "title": "<?php echo ( __("Minimize", "obscura") ) ?>",
                    "role": "button",
                    "aria-label": "<?php echo ( __("Minimize", "obscura") ) ?>"
                }).css({
                    "display": "block",
                    "position": "absolute",
                    "top": Math.round( ( ( bgHeight - fgHeight ) / 2 ) + 8 ) + 'px',
                    "right": Math.round( ( ( bgWidth - fgWidth ) / 2 ) + 8 ) + 'px',
                    "cursor": "pointer"
                }).click(obscura.hide).appendTo("#obscura-bg");
                bg.css({
                    "opacity": 1,
                    "cursor": "url('<?php echo ( Config::current()->chyrp_url."/modules/obscura/images/zoom-out.svg") ?>'), pointer"
                });
            },
            hide: function() {
                $("#obscura-bg").remove();
                obscura.active = false;
            }
        }
        $(document).ready(obscura.init);
<!-- --></script>
