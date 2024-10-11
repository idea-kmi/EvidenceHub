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

///////////////////////////////////////
// Activity Class
///////////////////////////////////////

class Activity {

    public $itemid;
    public $userid;
    public $type;
    public $modificationdate;
    public $changetype;
    public $xml;
    public $node;
    public $con;
    public $tombstone = false;
    public $user;

    private $currentnode;
    private	$currentcon;


   /**
     * Constructor
     *
     * @return Activity (this)
     */
    function Activity() {}

	function load($itemid, $userid, $type, $modificationdate, $changetype, $xml) {

		if (!isset($userid) || $userid == "") {
			$ERROR = new Hub_Error;
			$ERROR->createUserNotFoundError($userid);
			return $ERROR;
		}

		$this->itemid = $itemid;
		$this->userid = $userid;
		$this->type = $type;
		$this->modificationdate = $modificationdate;
		$this->changetype = $changetype;
		$this->xml = $xml;

		$this->user = new User($userid);
		$this->user->load();

		switch($this->type) {
			case "Node":
				$this->node = getIdeaFromAuditXML($this->xml);
				$this->currentnode = getNode($this->itemid);
				if ($this->currentnode instanceof Hub_Error) {
					if ($this->currentnode->code == 7007) { // NODE NOT FOUND
						$this->tombstone == true;
					}
				}
				break;
			case "Connection":
				$this->con = getConnectionFromAuditXML($this->xml);
				$this->currentcon = getConnection($this->itemid);
				if ($this->currentcon instanceof Hub_Error) {
					if ($this->currentcon->code == 7008) { // CONNECTION NODE FOUND
						$this->tombstone == true;
					}
				}
				break;
		}

		try {
			$this->canview();
		} catch (Exception $e){
			$this->itemid = "";
			$this->userid = "";
			$this->type = "";
			$this->modificationdate = "";
			$this->changetype = "";
			$this->xml = "";
			$this->user = "";
			$this->node = "";
			$this->con = "";
			$this->currentnode = "";
			$this->currentcon = "";

			return access_denied_error();
		}
	}

    /**
     * Check whether the current user can view the current activity
     *
     * @throws Exception
     */
    function canview(){
        global $USER;

        // if the logged in person is the owner, it's fine.
        if (isset($USER->userid) && $USER->userid != ""
        		&& $USER->userid == $this->userid) {
        	return true;
        }

		switch($this->type) {
			case "Node":
				$node = $this->node;
				if ($node instanceof CNode) {
					if ($this->tombstone) {
						// not a current node, must be a deleted node
						// so check it based on the XML stored permissions only
						if ($node->private == 'Y' && $node->users[0]->userid != $USER->userid) {
							throw new Exception("access denied");
						}
					} else {
						// if it is a current node,
						// check including group checking was done on loading
						if ($this->currentnode instanceof Hub_Error) {
							throw new Exception("access denied");
						}
					}
				} else {
					// if you can't load the XML forget it.
					throw new Exception("access denied");
				}
				break;
			case "Connection":
				$con = $this->con;
				if ($con instanceof Connection) {
					if ($this->tombstone) {
						// if it is a current node, do full check including group checking
						if ($this->currentcon instanceof Hub_Error) {
							throw new Exception("access denied");
						}
					} else {
						// not a current connection, must be a deleted one
						// so check XML stored permissions
						if ($con->private == 'N' || $con->users[0]->userid == $USER->userid) {
							$fromnode = $con->from;
							$tonode = $con->to;
							if (($fromnode->private == 'N' || $fromnode->users[0]->userid == $USER->userid) ||
								($tonode->private == 'N' || $tonode->users[0]->userid == $USER->userid)) {
								return true;
							} else {
								throw new Exception("access denied");
							}
						} else {
							throw new Exception("access denied");
						}
					}
				} else {
					// if you can't load the XML forget it.
					throw new Exception("access denied");
				}
				break;

			case "Vote": // public info
				return true;
				break;

			case "View": // public info ?? or only if you can view the node it relates to ??
				return true;
				break;
		}

        //if(api_check_login() instanceof Hub_Error){
        //    throw new Exception("access denied");
        //}
    }
}
?>