<?php
class Rubric extends DataModel {
	
	var $required = array('name','course_id');
	var $grading = false;
	
	/**
	 * Retrieves all active rubrics
	 */
	public static function findAll($active=true){
		$active = $active ? 1 : 0;
		return parent::find('Rubric',array('active'=>$active));
	}
	
	public function __toString() {
		$summary =	"<div class=\"rubric\" data-id=\"{$this->id}\">";

		$summary .=		'<div class="well">';
		$summary .=			'<div class="actions actions-rubric pull-right">';
		$summary .=				"<a href=\"./?p=grade&rubric={$this->id}\" title=\"Grade\" class=\"pull-left btn btn-primary\"><i class=\"icon icon-white icon-th-list\"></i></a>";
		$summary .=				'<div class="btn-group pull-right">';
		$summary .=					'<a href="#" class="dropdown-toggle btn" data-toggle="dropdown">';
		$summary .=						'<i class="icon-cog"></i>';
		$summary .=						'<span class="caret"></span>';
		$summary .=					'</a>';
		$summary .=					'<ul class="dropdown-menu">';
		$summary .=						'<li><a href="#" onclick="toggleRubricForm()" title="Edit Rubric">Edit</a></li>';
		$summary .=						"<li><a class=\"noajax\" data-confirm=\"true\" data-submit-type=\"post\" data-id=\"{$this->id}\" data-confirm-message=\"Are you sure you want to delete this rubric?\" data-action=\"./?action=deleteRubric\" href=\"#modal\" title=\"Delete Rubric\">Delete</a></li>";
		$summary .=					'</ul>';
		$summary .=				'</div>';
		$summary .=			'</div>';
		$summary .=			"<h2>{$this->name}</h2>";
		$summary .=		'</div>';
		
		// Get points possible for this rubric
		$points = $this->getPoints();
		
		$summary .=	'<ul class="stack header">';
		$summary .=	'<li class="listheader">Description<span class="ui-li-count pull-right">Points Possible</span></li>';
		$summary .=	"</ul>";
		
		$summary .=	'<ul class="stack regular">';
		
		// If criteria were found
		if(count($this->criteria) > 0) {
			foreach($this->criteria as $criterion) {
				if($criterion->extracredit == 0) {
					$summary .=	"<li class=\"rubric-item\" data-criterion_id=\"{$criterion->id}\" data-criterion_weight=\"{$criterion->weight}\" data-criterion_extracredit=\"{$criterion->extracredit}\">{$criterion->description}<span class=\"ui-li-count badge badge-info pull-right\">{$criterion->weight}</span></li>";
				}
			}
			$subtotalHeading = ($points['extra'] > 0) ? 'Subtotal' : 'Total';
			$summary .=	"<li class=\"listheader subtotal\">{$subtotalHeading}<span class=\"ui-li-count pull-right\">{$points['total']}</span></li>";
		} else {
			//$summary .= '<li class="placeholder">No regular criteria</li>';
		}
		$summary .=	"</ul>";
		$summary .=	'<ul class="stack extra">';
		
		// If there are extra credit items
		if($points['extra'] > 0) {
			foreach($this->criteria as $criterion) {
				if($criterion->extracredit == 1) {
					$summary .=	"<li class=\"rubric-item\" data-criterion_id=\"{$criterion->id}\" data-criterion_weight=\"{$criterion->weight}\" data-criterion_extracredit=\"{$criterion->extracredit}\">{$criterion->description}<span class=\"ui-li-count badge badge-success pull-right\">{$criterion->weight}</span></li>";
				}
			}
			$summary .=	"<li class=\"listheader extra\">Extra Credit<span class=\"ui-li-count pull-right\">{$points['extra']}</span></li>";
		} else {
			//$summary .= '<li class="placeholder">No extra credit criteria</li>';
		}
		$summary .=	"</ul>";
		
		$pointsPossible = $points['total'] + $points['extra'];
		$summary .=	'<ul class="stack total">';
		$summary .=	"<li class=\"listheader extra\">Total Points Possible<span class=\"ui-li-count pull-right\">{$pointsPossible}</span></li>";
		$summary .=	"</ul>";
		
		$summary .= '</div>';
		return $summary;
	}

	public function getGradingForm() {
		$form =	"<div class=\"rubric\" data-id=\"{$this->id}\">";
		$form .= '<form id="form-scoring" action="actions/score.php" method="post">';
		$form .= 	"<input type=\"hidden\" name=\"rubric_id\" value=\"{$this->id}\" />";
		$form .= 	'<input type="hidden" name="student_id" value="" />';
		$form .=		'<div class="well">';
		$form .=			"<h2>{$this->name}</h2>";
		$form .=		'</div>';
		
		// Get points possible for this rubric
		$points = $this->getPoints();
		
		$form .=	'<ul class="stack header">';
		$form .=	'<li class="listheader">Description<span class="ui-li-count pull-right">Points</span></li>';
		$form .=	"</ul>";
		
		$form .=	'<ul class="stack regular">';
		
		// If criteria were found
		if(count($this->criteria) > 0) {
			foreach($this->criteria as $criterion) {
				if($criterion->extracredit == 0) {
					$grade = "<input class=\"pull-right score\" type=\"text\" name=\"criterion-{$criterion->id}\" id=\"criterion-{$criterion->id}\" value=\"0\" />";
					$slider = '<div class="slider"></div>';
					
					$form .=	"<li class=\"rubric-item\" data-criterion-id=\"{$criterion->id}\" data-criterion-weight=\"{$criterion->weight}\" data-criterion-extracredit=\"{$criterion->extracredit}\">{$criterion->description}<span class=\"ui-li-count badge badge-info pull-right\">{$criterion->weight}</span>{$grade}{$slider}</li>";
				}
			}
			$subtotalHeading = ($points['extra'] > 0) ? 'Subtotal' : 'Total';
			$form .=	"<li class=\"listheader subtotal\">{$subtotalHeading}<span class=\"ui-li-count total-possible pull-right\">{$points['total']}</span><span class=\"pull-right total\" id=\"sub-total\">8</span></li>";
		} else {
			//$summary .= '<li class="placeholder">No regular criteria</li>';
		}
		$form .=	"</ul>";
		$form .=	'<ul class="stack extra">';
		
		// If there are extra credit items
		if($points['extra'] > 0) {
			foreach($this->criteria as $criterion) {
				if($criterion->extracredit == 1) {
					$grade = "<input class=\"pull-right score\" type=\"text\" name=\"criterion-{$criterion->id}\" id=\"criterion-{$criterion->id}\" value=\"0\" />";
					$slider = '<div class="slider"></div>';

					$form .=	"<li class=\"rubric-item\" data-criterion-id=\"{$criterion->id}\" data-criterion-weight=\"{$criterion->weight}\" data-criterion-extracredit=\"{$criterion->extracredit}\">{$criterion->description}<span class=\"ui-li-count badge badge-success pull-right\">{$criterion->weight}</span>{$grade}{$slider}</li>";
				}
			}
			$form .=	"<li class=\"listheader extra\">Extra Credit<span class=\"ui-li-count total-possible pull-right\">{$points['extra']}</span><span class=\"pull-right total\" id=\"extra-total\">8</span></li>";
		} else {
			//$summary .= '<li class="placeholder">No extra credit criteria</li>';
		}
		$form .=	"</ul>";
		
		$pointsPossible = $points['total'] + $points['extra'];
		$form .=	'<ul class="stack total">';
		$form .=	"<li class=\"listheader extra\">Total Points Possible<span class=\"ui-li-count total-possible pull-right\">{$pointsPossible}</span><span class=\"pull-right total\" id=\"grand-total\">8</span></li>";
		$form .=	"</ul>";
		
		$form .= '</form>';
		
		$form .= '</div>';
		return $form;
	}
	
	public function getPoints() {
		$total = 0;
		$extra = 0;
		if(count($this->criteria) > 0) {
			foreach($this->criteria as $criterion) {
				if($criterion->extracredit == 0) {
					$total += $criterion->weight;
				} else {
					$extra += $criterion->weight;
				}
			}
		}
		return array('total'=>$total,'extra'=>$extra);
	}
	
	public static function match($fields){
		$result = parent::match('Rubric',$fields);		
		$result->criteria = Criterion::find(array('rubric_id' => $result->id));
		return $result;
	}
	
}