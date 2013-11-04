<?php

namespace view;

/*
Insperation https://github.com/tamtranvn2012/bcd/blob/f0fd79207f07c61c716240c12c35a0479827f541/wp-content/plugins/profile-builder-pro/premium/addon/pagination.class.php
*/

class Pagenation {

  /**
   * @var array
   */
  private $array;

  /**
   * @var string
   */
  private $perPage;

  /**
   * @var string
   */
  private $page;

  /**
   * @var string
   */
  private $pages;

  /**
  * @param array
  * @param string
  * @param string
  */
  public function init($array, $perPage)
  {
    $this->array   = $array;
    $this->perPage = $perPage;
  }

  /**
   * @return array
   */
  public function getPagenationResults() {

    // Assign the page varible
    if (!empty($_GET['page'])) {
      $this->page = $_GET['page']; // using get
    } else {
      $this->page = 1; // if we dont have a page nr 
    }

    // Take the length of the array
    $length = count($this->array);

    // Get the number of pages
    $this->pages = ceil($length / $this->perPage);

    // Calculate the starting point
    $start = ceil(($this->page - 1) * $this->perPage);

    // return the portion of results
    return array_slice($this->array, $start, $this->perPage);
  }

  /**
  * @return string
  */
  public function getLinks()
  {

    $prewLink = "";
    $nextLink = "";
    $links = array();

    // If we have more then one pages
    if (($this->pages) > 1) {
      // Assign the 'previous page' link into the array if we are not on the first page
      if ($this->page != 1) {
        $prewLink = ' <a href="?page='.($this->page - 1).'">&laquo; Prev</a> ';
      }

      // Assign all the page numbers & links to the array
      for ($j = 1; $j < ($this->pages + 1); $j++) {
        if ($this->page == $j) {
          $links[] = ' <span class="pagenation-active">'.$j.'</span> '; // If we are on the same page as the current item
        } else {
          $links[] = ' <a href="?page='.$j.'">'.$j.'</a> '; // add the link to the array
        }
      }

      // Assign the 'next page' if we are not on the last page
      if ($this->page < $this->pages) {
        $nextLink = ' <a href="?page='.($this->page + 1).'"> Next &raquo; </a> ';
      }

      $ret = ' ' .  $prewLink . implode('', $links) . ' ' . $nextLink;
      return $ret;
    }
    return;
  }

}