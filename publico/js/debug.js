$.ajax({
    url: 'index.php?c=imagens&a=obterDescritores',
    type: 'POST',
    dataType: 'JSON',
    success: function(data) {
//        console.log(data);
        $('.typeahead').typeahead({
            source: ['em pé'],
            updater: function(item) {
                return this.$element.val().replace(/[^,]*$/, '') + item + ',';
            },
            matcher: function(item) {
                var tquery = extractor(this.query);
                if (!tquery)
                    return false;
                return ~item.toLowerCase().indexOf(tquery.toLowerCase())
            },
            highlighter: function(item) {
                var query = extractor(this.query).replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
                return item.replace(new RegExp('(' + query + ')', 'ig'), function($1, match) {
                    return '<strong>' + match + '</strong>'
                })
            }
        });
    }
});