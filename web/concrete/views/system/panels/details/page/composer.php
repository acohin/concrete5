<?
defined('C5_EXECUTE') or die("Access Denied.");
$token = Loader::helper('validation/token')->generate('composer');
$cID = $c->getCollectionID();
?>

<section class="ccm-ui">
	<header><?=t('Composer - %s', $pagetype->getPageTypeName())?></header>
	<form method="post" data-panel-detail-form="compose">
		<?=Loader::helper('concrete/interface/help')->notify('panel', '/page/composer')?>

		<? Loader::helper('composer')->display($pagetype, $c); ?>
	</form>

	<div class="ccm-panel-detail-form-actions">
		<? Loader::helper('composer')->displayButtons($pagetype, $c); ?>
	</div>
</section>

<script type="text/javascript">
ConcretePageComposerDetail = {

	timeout: 5000,
	saving: false,
	interval: false,
	$form: $('form[data-panel-detail-form=compose]'),

	saveDraft: function(onComplete) {
		var my = this;
		my.$form.concreteAjaxForm({
    		'beforeSubmit': function() {
    			my.saving = true;
    		},
			url: '<?=$controller->action('autosave')?>',
			success: function(r) {
				my.saving = false;
		        $('#ccm-page-type-composer-form-save-status').html(r.message).show();
		        if (onComplete) {
		        	onComplete();
		        }
			}
		}).submit();
	},

	enableAutosave: function() {
		var my = this;
		my.interval = setInterval(function() {
			ConcretePageComposerDetail.saveDraft();
		}, my.timeout);
	},

	disableAutosave: function() {
		var my = this;
	   	clearInterval(my.interval);
	},

	start: function() {
		var my = this;
	    $('button[data-page-type-composer-form-btn=discard]').on('click', function() {
	    	my.disableAutosave();
	    	$.concreteAjax({
	    		'url': '<?=$controller->action('discard')?>',
	    		'data': {token: '<?=$token?>', cID: '<?=$cID?>'}, 
	    		success: function(r) {
					window.location.href = r.redirectURL;
	    		}
	    	});
		});

	    $('button[data-page-type-composer-form-btn=preview]').on('click', function() {
	    	my.disableAutosave();
	    	redirect = function () {
	   			window.location.href = CCM_DISPATCHER_FILENAME + '?cID=' + '<?=$cID?>';
	    	}
	    	if (!my.saving) {
	    		my.saveDraft(redirect);
	    	} else {
	    		redirect();
	    	}
		});

	    $('button[data-page-type-composer-form-btn=publish]').on('click', function() {
	    	my.disableAutosave();
	    	var submitSuccess = false;
			my.$form.concreteAjaxForm({
				url: '<?=$controller->action('publish')?>',
				success: function(r) {
					submitSuccess = true;
					ConcreteAlert.showResponseNotification(r.message, 'ok', 'success');
					CCMPanelManager.exitPanelMode();
					setTimeout(function() {
						window.location.href = r.redirectURL;
					}, 1000);
				},
				complete: function() {
					if (!submitSuccess) {
				    	my.enableAutosave();
					}
					jQuery.fn.dialog.hideLoader();
				}
			}).submit();
		});

		ccm_event.subscribe('panel.closeDetail',function(e) {
			var panelDetail = e.eventData;
			if (panelDetail && panelDetail.identifier == 'page-composer') {
				my.disableAutosave();
			}
		});

	    my.enableAutosave();
	}

}

$(function() {
	ConcretePageComposerDetail.start();
});
</script>