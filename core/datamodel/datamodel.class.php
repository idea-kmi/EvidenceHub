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

/**
 * DESCRIBES THE DATAMODEL OF CONNECTIONS.
 * For the evidence hub server side code to use.
 **/

/**
 * The object that holds all the information about a given connection definition
 */
class DataModelConnection {

	private $fromnodetypeArray;
	private $tonodetypeArray;
	private $linktype;

	function load($fromnodetypes, $linktype, $tonodetypes) {
		$this->fromnodetypeArray = $fromnodetypes;
		$this->linktype = $linktype;
		$this->tonodetypeArray = $tonodetypes;
	}

	/**
	 * do the passed items match this Connection definition
	 */
	function matches($fromnode, $link, $tonode) {
		$matches  = false;

		/*echo "in array from=".$fromnode;
		echo "\n\r";
		echo "in array to=".$tonode;
		echo "\n\r";
		echo "link=".$link;
		echo "\n\r";
		print_r($this->tonodetypeArray);
		echo "\n\r";
		echo "\n\r";
		*/

		if (in_array($fromnode, $this->fromnodetypeArray)
			&& $this->linktype === $link
				&& in_array($tonode, $this->tonodetypeArray)) {
			$matches = true;
			//echo "MATCHES";
		}

		return $matches;
	}
}


/**
 * The object that holds all the connection definitions and functions to check data against them.
 */
class DataModel {

	private $hubmodel = array();

	function load() {
		global $CFG;

		$NODE_SET_RESOURCE = array_merge( array("Organization","Project"), $CFG->EVIDENCE_TYPES);
		$NODE_SET_COMMENT = array_merge(array("Challenge","Issue","Claim","Solution","Organization","Project","Theme"), $CFG->EVIDENCE_TYPES, $CFG->RESOURCE_TYPES);
		$NODE_SET_THEME = array_merge(array("Challenge","Issue","Claim","Solution","Organization","Project"), $CFG->EVIDENCE_TYPES, $CFG->RESOURCE_TYPES);
		$NODE_SET_ORG = array("Organization","Project");
		//$NODE_SET_SEE_ALSO_FROM = array_merge(array("Challenge","Issue","Claim","Solution","Project","Organization"), $CFG->EVIDENCE_TYPES);
		$NODE_SET_SEE_ALSO_FROM = array_merge(array("Challenge","Issue","Claim","Solution","Project","Organization"), $CFG->EVIDENCE_TYPES, $CFG->RESOURCE_TYPES);
		$NODE_SET_SEE_ALSO_TO = array_merge(array("Challenge","Issue","Claim","Solution","Project","Organization", "Comment"), $CFG->EVIDENCE_TYPES, $CFG->RESOURCE_TYPES);
		$NODE_SET_BUILT_FROM = array_merge( array("Challenge","Issue","Solution","Claim"), $CFG->EVIDENCE_TYPES);

		$this->hubmodel[0] = new DataModelConnection();
		$this->hubmodel[0]->load( (array("Issue")), $CFG->LINK_ISSUE_CHALLENGE, (array("Challenge")));
		$this->hubmodel[1] = new DataModelConnection();
		$this->hubmodel[1]->load(array("Claim"), $CFG->LINK_CLAIM_ISSUE, array("Issue"));
		$this->hubmodel[2] = new DataModelConnection();
		$this->hubmodel[2]->load(array("Solution"), $CFG->LINK_SOLUTION_ISSUE, array("Issue"));
		$this->hubmodel[3] = new DataModelConnection();
		$this->hubmodel[3]->load($NODE_SET_ORG, $CFG->LINK_ORGP_ISSUE, array("Issue"));
		$this->hubmodel[4] = new DataModelConnection();
		$this->hubmodel[4]->load($NODE_SET_ORG, $CFG->LINK_ORGP_CHALLENGE, array("Challenge"));
		$this->hubmodel[5] = new DataModelConnection();
		$this->hubmodel[5]->load($NODE_SET_ORG, $CFG->LINK_ORGP_CLAIM, array("Claim"));
		$this->hubmodel[6] = new DataModelConnection();
		$this->hubmodel[6]->load($NODE_SET_ORG, $CFG->LINK_ORGP_SOLUTION, array("Solution"));
		$this->hubmodel[7] = new DataModelConnection();
		$this->hubmodel[7]->load($NODE_SET_ORG, $CFG->LINK_ORGP_EVIDENCE, $CFG->EVIDENCE_TYPES);
		$this->hubmodel[8] = new DataModelConnection();
		$this->hubmodel[8]->load($NODE_SET_ORG, $CFG->LINK_ORGP_ORGP, $NODE_SET_ORG);
		$this->hubmodel[9] = new DataModelConnection();
		$this->hubmodel[9]->load(array("Organization"), $CFG->LINK_ORG_PROJECT, array("Project"));
		$this->hubmodel[10] = new DataModelConnection();
		$this->hubmodel[10]->load(array("Comment"), $CFG->LINK_COMMENT_NODE, $NODE_SET_COMMENT);
		$this->hubmodel[11] = new DataModelConnection();
		$this->hubmodel[11]->load($NODE_SET_THEME, $CFG->LINK_NODE_THEME, array("Theme"));
		$this->hubmodel[12] = new DataModelConnection();
		$this->hubmodel[12]->load($CFG->RESOURCE_TYPES, $CFG->LINK_RESOURCE_NODE, $NODE_SET_RESOURCE);
		$this->hubmodel[13] = new DataModelConnection();
		$this->hubmodel[13]->load($NODE_SET_SEE_ALSO_FROM, $CFG->LINK_NODE_SEE_ALSO, $NODE_SET_SEE_ALSO_TO);
		$this->hubmodel[14] = new DataModelConnection();
		$this->hubmodel[14]->load(array("Comment"), $CFG->LINK_COMMENT_NODE, array("Comment"));
		$this->hubmodel[15] = new DataModelConnection();
		$this->hubmodel[15]->load($NODE_SET_BUILT_FROM, $CFG->LINK_COMMENT_BUILT_FROM, array("Comment","Idea"));
	}

	function matchesModel($fromnode, $link, $tonode) {
		$matches = false;

		$i=0;
		$count=count($this->hubmodel);
		for ($i=0; $i<$count; $i++) {
			$next = $this->hubmodel[$i];
			//echo $i." ";
			if ($next->matches($fromnode, $link, $tonode)) {
				$matches = true;
				break;
			}
		}

		return $matches;
	}

 	function matchesModelPro($fromnode, $link, $tonode) {
 		global $CFG;

		$matches = false;

		if (in_array($fromnode, $CFG->EVIDENCE_TYPES)
			&& $link === $CFG->LINK_EVIDENCE_SOLCLAIM_PRO
				&& in_array($tonode, array("Claim","Solution"))) {

			$matches = true;
		}

		return $matches;
	}

	function matchesModelCon($fromnode, $link, $tonode) {
		global $CFG;

		$matches  = false;

		if (in_array($fromnode, $CFG->EVIDENCE_TYPES)
			&& $link === $CFG->LINK_EVIDENCE_SOLCLAIM_CON
				&& in_array($tonode, array("Claim","Solution")) ) {

			$matches = true;
		}

		return $matches;
	}
}
?>