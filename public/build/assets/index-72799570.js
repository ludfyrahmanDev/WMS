(function(){$(".dark-mode-switcher").on("click",function(){$(this).hasClass("dark-mode-switcher--active")?$(this).removeClass("dark-mode-switcher--active"):$(this).addClass("dark-mode-switcher--active"),setTimeout(()=>{const e=$(".dark-mode-switcher").data("url");window.location.href=e},500)})})();