<?php

namespace view;

class AdminCommentView {

	/**
	 * @var string
	 */
	private $message = "";

	/**
	* @var string
	**/
	const removeCommentSuccess = "Successfully deleted the comment!";

	/**
	* @param array
	* @return string html
	**/
	public function allComments($comments) {

		$html ="<div class='adminContent'>
					<h2><span class='glyphicon glyphicon-list-alt'></span> All Comments</h2>
					$this->message";
		$html .= "<table>
					<tr>
						<th></th>
						<th id='tableAuthor'>Author</th>
						<th id='tableComment'>Comment</th>
						<th>Date</th>
					</tr>";

		foreach ($comments as $comment) {
			$id = $comment->getId();
			$author = $comment->getAuthor();
			$content = $comment->getComment();
			$date = $comment->getCreatDate();

			$html .= "<tr>";
			$html .= "<td><a href='?admin&removeComment&commentID=$id'><span class='glyphicon glyphicon-remove'></span></td></a>";
			$html .= "<td>$author</td>";
			$html .= "<td>$content</td>";
			$html .= "<td>$date</td>";
			$html .= "</tr>";
		}

		$html .= "</table>
				</div>";

		return $html;
	}

	public function removeCommentSuccess() {
		$this->message = "<div class='alert alert-success'>" . self::removeCommentSuccess . "</div>";
	}

	public function removeCommentFail() {
		$this->message = "<div class='alert alert-danger'>Comment do not exist</div>";
	}

	/**
	* @return boolian
	**/
	public function removeComment() {
		return isset($_GET["removeComment"]);
	}

	/**
	* @return string
	**/
	public function getCommentID() {
		return $_GET["commentID"];
	}
}