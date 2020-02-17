<div class="alert alert-light text-center border-bottom">
    <span class='font-weight-bold super-small-font text-muted'>Share Your Link (click it to copy)</span>
    <br>
    <span class='link-color small-font py-3' id="clickToCopyDiv" onclick="copyToClipboard()">https://socialshub.net/<?php echo $user->screenName; ?></span>
</div>

<script>
    function copyToClipboard() {
        var range = document.createRange();
        range.selectNode(document.getElementById("clickToCopyDiv"));
        window.getSelection().removeAllRanges(); // clear current selection
        window.getSelection().addRange(range); // to select text
        document.execCommand("copy");
        window.getSelection().removeAllRanges();// to deselect
    }
</script>