var btn = document.getElementsByName('randomize')[0];
btn.addEventListener('click', function(){
    var max = document.getElementsByName('subforum_title')[0].value.length;
    if (max > 0)
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < max; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
        document.getElementsByName('subforum_keyword')[0].value = text;
    }
});
