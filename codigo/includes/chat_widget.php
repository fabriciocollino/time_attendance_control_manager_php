<?php

//logica para el chat
$activarChat = 0;

if (isMobile() && Config_L::p("ver_chat_soporte_mobile")) {
    $activarChat = 1;
}

if (!isMobile() && (Config_L::p("chat_soporte_enabled") && Config_L::p("ver_chat_soporte"))) {
    $activarChat = 1;
}

?>
<?php if ($activarChat) { ?>
    <style type="text/css">
        .zopim {
            overflow: visible !important;
        }
        
    </style>
    <script type="text/javascript">
        function loadchat() {
            window.$zopim = null;
            window.$zopim || (function (d, s) {
                var z = $zopim = function (c) {
                    z._.push(c)
                }, $ = z.s =
                    d.createElement(s), e = d.getElementsByTagName(s)[0];
                z.set = function (o) {
                    z.set._.push(o)
                };
                z._ = [];
                z.set._ = [];
                $.async = !0;
                $.setAttribute("charset", "utf-8");
                $.src = "//v2.zopim.com/?3DGUFQz8rh3PDLOIIHWjJ8p3xAB64b7V";
                z.t = +new Date;
                $.type = "text/javascript";
                e.parentNode.insertBefore($, e)
            })(document, "script");
            $zopim(function () {
                $zopim.livechat.setName("<?php echo isset($_SESSION['USUARIO']['id']) ? Registry::getInstance()->Usuario->getNombre() . ' ' . Registry::getInstance()->Usuario->getApellido() : _('Anónimo??'); ?>");
                $zopim.livechat.setEmail('<?php echo isset($_SESSION['USUARIO']['id']) ? Registry::getInstance()->Usuario->getEmail() : _('Anónimo??'); ?>');
                $zopim.livechat.setPhone('<?php echo isset($_SESSION['USUARIO']['id']) ? Registry::getInstance()->Usuario->getTeCelular() : _('Anónimo??'); ?>');
                $zopim.livechat.setLanguage('es');
                $zopim.livechat.theme.setColor('#474544');
                $zopim.livechat.window.setTitle('Chat Soporte Técnico');
                $zopim.livechat.setGreetings({
                    'online': 'Soporte Técnico',
                    'offline': 'Offline, déjanos un mensaje'
                });
                $zopim.livechat.badge.hide();

            });

        }
       setTimeout(loadchat, 500);
        //loadchat();
    </script>


<?php } ?>