<?php global $config; ?>
</div>

<footer>

    <div style="display: flex;">
        <div style="">Copyright &copy; 2023</div>
        <div style="flex: 1; text-align: right;">
            <a href="https://github.com/atas/ssg" target="_blank">
                Last deploy: <?= date("Y-m-d") . " at " . date("h:ia"); ?>
            </a>
        </div>
    </div>

    <div class="gdprInfo">
        <!-- TODO: Add GDPR info or a GDPR banner if using advanced analytics -->
        This site respects your privacy with GDPR-compliant, self-hosted and anonymised analytics without using cookies
        and sharing data.
    </div>
</footer>

</div>

<script>
    setBodyWrapperMarginTop();
</script>

<!-- TODO: Add your analytics -->

</body>
</html>
