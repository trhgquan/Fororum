var btn = document.getElementsByName('randomize')[0];
btn.addEventListener('click', function(){
    var str = document.getElementsByName('subforum_title')[0].value;
    var max = str.length;
    if (max > 0)
    {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "àáãảäăâắấằầạậặđèéëêếềìíĩỉïîòóöôốồộùúũüûưñçýỳỹỷ·/_,:;";
        var to   = "aaaaaaaaaaaaaadeeeeeeiiiiiiooooooouuuuuuncyyyy------";
        for (var i=0, l=from.length ; i<l ; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
        document.getElementsByName('subforum_keyword')[0].value = str;
    }
});
