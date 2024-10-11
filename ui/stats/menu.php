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

$page = optional_param("page","overview",PARAM_TEXT);
?>
<div class="container-fluid">
	<div class="row px-4 py-0">
		<div class="col-12">
			<div id="tabber" class="tabber-stats">
				<ul id="tabs" class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link <?php if ($page == "overview") { echo 'active'; } ?>" href="index.php?page=overview"><span class="tab"><?php echo $LNG->STATS_GLOBAL_TAB_OVERVIEW; ?></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == "register") { echo 'active'; } ?>" href="userRegistration.php?page=register"><span class="tab"><?php echo $LNG->STATS_GLOBAL_TAB_REGISTER; ?></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == "ideas") { echo 'active'; } ?>" href="newIdeas.php?page=ideas"><span class="tab"><?php echo $LNG->STATS_GLOBAL_TAB_IDEAS; ?></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == "conns") { echo 'active'; } ?>" href="connections.php?page=conns"><span class="tab"><?php echo $LNG->STATS_GLOBAL_TAB_CONNS; ?></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == "votes") { echo 'active'; } ?>" href="votes.php?page=votes"><span class="tab"><?php echo $LNG->STATS_GLOBAL_TAB_VOTES; ?></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == "tabs") { echo 'active'; } ?>" href="tags.php?page=tabs"><span class="tab"><?php echo $LNG->STATS_GLOBAL_TAB_TAGS; ?></span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

