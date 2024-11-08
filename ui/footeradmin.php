<?php
	/********************************************************************************
	 *                                                                              *
	 *  (c) Copyright 2010 - 2024 The Open University UK                            *
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
	</div> <!-- end innertube -->
	</div> <!-- end content -->
	</div> <!-- end contentwrapper -->
	</div> <!-- end main -->

	<div id="footer" class="footerback footer bg-light border-top">
		<div class="container-fluid">
			<div class="row">
				<div class="text-end p-4">
					<div class="d-block px-4 mb-2">
						<a href="<?php print($CFG->homeAddress);?>ui/pages/conditionsofuse.php"><?php echo $LNG->FOOTER_TERMS_LINK; ?></a> |
						<a href="http://kmi.open.ac.uk/accessibility/"><?php echo $LNG->FOOTER_ACCESSIBILITY; ?></a> |
						<a href="<?php print($CFG->homeAddress);?>ui/pages/privacy.php"><?php echo $LNG->FOOTER_PRIVACY_LINK; ?></a> |
						<a href="<?php print($CFG->homeAddress);?>ui/pages/cookies.php"><?php echo $LNG->FOOTER_COOKIES_LINK; ?></a> |
						<a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>?subject=<?php echo $CFG->SITE_TITLE; ?>"><?php echo $LNG->FOOTER_CONTACT_LINK; ?></a>
					</div>
					<div class="d-block px-4">
						<span><?php echo $LNG->FOOTER_FAMILY_MESSAGE_PART1; ?> </span>
						<a href="http://evidence-hub.net/" title="<?php echo $LNG->FOOTER_EVIDENCE_HUB_HINT; ?>">
						<img alt="Evidence-Hub.net" src="<?php echo $HUB_FLM->getImagePath('evidence-hub-logo-footer.png'); ?>" />
						</a><span> <?php echo $LNG->FOOTER_FAMILY_MESSAGE_PART2; ?></span>
					</div>
				</div>
			</div>
			<div class="d-block text-center"><small>version: <?php echo $CFG->VERSION; ?></small></div>
		</div>
	</div>

	</body>
</html>
