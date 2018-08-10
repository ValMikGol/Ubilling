<?php

if (cfr('STICKYNOTES')) {
    $altCfg = $ubillingConfig->getAlter();
    if ($altCfg['STICKY_NOTES_ENABLED']) {
        //creating main object
        $stickyNotes = new StickyNotes(false);


        // new note creation
        if (wf_CheckPost(array('newtext'))) {
            $stickyNotes->addMyNote();
            rcms_redirect('?module=stickynotes');
        }

        //note deletion
        if (wf_CheckGet(array('delete'))) {
            $stickyNotes->deleteNote($_GET['delete']);
            rcms_redirect('?module=stickynotes');
        }

        //note editing
        if (wf_CheckPost(array('edittext', 'editnoteid'))) {
            $stickyNotes->saveMyNote();
            rcms_redirect('?module=stickynotes');
        }

        //control panel display
        show_window('', $stickyNotes->panel());

        if ((!wf_CheckGet(array('shownote'))) AND ( !wf_CheckGet(array('editform')))) {
            //grid or calendar view switch
            if (!wf_CheckGet(array('calendarview'))) {
                show_window(__('Available personal notes'), $stickyNotes->renderListGrid());
            } else {
                show_window(__('Available personal notes'), $stickyNotes->renderListCalendar());
            }
        } else {
            if (wf_CheckGet(array('shownote'))) {
                show_window(__('Sticky note'), $stickyNotes->renderNote($_GET['shownote']));
            }

            if (wf_CheckGet(array('editform'))) {
                show_window(__('Edit'), $stickyNotes->editForm($_GET['editform']));
                show_window('', wf_BackLink($stickyNotes::URL_ME));
            }
        }
    } else {
        show_window(__('Error'), __('This module is disabled'));
    }
} else {
    show_error(__('Access denied'));
}
?>