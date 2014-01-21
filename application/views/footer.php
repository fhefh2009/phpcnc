<script>
    $(function(){
        $(".navbar-form").submit(function(){
            var q = $(".navbar-form input").val();
            if(q) open('https://www.google.com/search?q=site:phpcnc.org%20' + q, "_blank");
            return false;
        });
    });
</script>
</body>
</html>