<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2013 The Open University UK                                   *
 *                                                                              *
 *  This software is freely distributed in accordance with                      *
 *  the GNU Lesser General Public (LGPL) license, version 3 or later            *
 *  as published by the Free Software Foundation.                               *
 *  For details see LGPL: http://www.fsf.org/licensing/licenses/lgpl.html       *
 *               and GPL: http://www.fsf.org/licensing/licenses/gpl-3.0.html    *
 *                                                                              *
 *  This software is provided by the copyright holders and contributors "as is" *
 *  and any express or implied warranties, including, but not limited to, the   *
 *  implied warranties of merchantability and fitness for a particular purpose  *
 *  are disclaimed. In no event shall the copyright owner or contributors be    *
 *  liable for any direct, indirect, incidental, special, exemplary, or         *
 *  consequential damages (including, but not limited to, procurement of        *
 *  substitute goods or services; loss of use, data, or profits; or business    *
 *  interruption) however caused and on any theory of liability, whether in     *
 *  contract, strict liability, or tort (including negligence or otherwise)     *
 *  arising in any way out of the use of this software, even if advised of the  *
 *  possibility of such damage.                                                 *
 *                                                                              *
 ********************************************************************************/
?>
</div> <!-- end content -->
</div> <!-- end main -->

<div id="footer" class="footerback">
	<div style="height:95px; margin-left: 15px; margin-right: 10px; margin-top: 10px;">
		<div style="float:right;border:margin-right:5px;">
			<div style="clear:both;float:right; line-height:24px; margin-top:38px;">
				<a href="<?php print($CFG->homeAddress);?>ui/pages/conditionsofuse.php"><?php echo $LNG->FOOTER_TERMS_LINK; ?></a> |
				<a href="http://kmi.open.ac.uk/accessibility/"><?php echo $LNG->FOOTER_ACCESSIBILITY; ?></a> |
				<a href="<?php print($CFG->homeAddress);?>ui/pages/privacy.php"><?php echo $LNG->FOOTER_PRIVACY_LINK; ?></a> |
				<a href="<?php print($CFG->homeAddress);?>ui/pages/cookies.php"><?php echo $LNG->FOOTER_COOKIES_LINK; ?></a> |
				<a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>?subject=<?php echo $CFG->SITE_TITLE; ?>"><?php echo $LNG->FOOTER_CONTACT_LINK; ?></a>
			</div>
			<div style="clear:both;float:right;line-height:25px;width: 255px;padding-top:5px">
				<span style="float:left; margin-right:5px;margin-top:3px;"><?php echo $LNG->FOOTER_FAMILY_MESSAGE_PART1; ?> </span>
				<a href="http://evidence-hub.net/" title="<?php echo $LNG->FOOTER_EVIDENCE_HUB_HINT; ?>">
				<img style="float:left; vertical-align: top" src="<?php echo $HUB_FLM->getImagePath('evidence-hub-logo-footer.png'); ?>" border="0" />
				</a><span style="float:left; margin-left:5px;margin-top:3px;"> <?php echo $LNG->FOOTER_FAMILY_MESSAGE_PART2; ?></span>
			</div>
		</div>
	</div>
</div>

<div style="margin:0 auto; margin-top:5px;margin-bottom:5px;width:95px;clear:both;float;left;font-style:italic;font-weight:bold">(v <?php echo $CFG->VERSION; ?>)</div>

<?php if ($CFG->GOOGLE_ANALYTICS_ON) { ?>
<!-- Google analytics -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
if (typeof(_gat)=="object") {
    var pageTracker = _gat._getTracker("<?php print($CFG->GOOGLE_ANALYTICS_KEY);?>");
	pageTracker._setCookiePath("/test");
    pageTracker._initData();
    pageTracker._trackPageview();
}
</script>
<?php } ?>

</body>
</html>


