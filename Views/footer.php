

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap tether Core JavaScript -->
<script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="/Views/js/jquery.slimscroll.js"></script>

<!--Wave Effects -->
<script src="/Views/js/waves.js"></script>

<!--Menu sidebar -->
<script src="/Views/js/sidebarmenu.js"></script>

<!--stickey kit -->
<script src="/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>

<!--Custom JavaScript -->
<script src="/Views/js/custom.js"></script>
<script src="/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
<script src="/assets/plugins/toast-master/js/jquery.toast.js"></script>

<script src="/assets/plugins/autocomplete/autocomplete.js"></script>


<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>


<!-- Sweet-Alert  -->
<script src="/assets/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/assets/plugins/sweetalert/jquery.sweet-alert.custom.js"></script>

<!-- Own Scripting -->
<script src="/Views/js/glas.js"></script>

<script>
window.addEventListener('load', function() {
    <? if($data['errorDialog']):?>
        swal("<?=$data['errorDialog']['title']?>", "<?=htmlspecialchars($data['errorDialog']['message'])?>", "error");
    <? elseif($data['successDialog']): ?>
        swal("<?=$data['successDialog']['title']?>", "<?=htmlspecialchars($data['successDialog']['message'])?>", "success");
    <? endif; ?>
});
</script>

</body>

</html>
