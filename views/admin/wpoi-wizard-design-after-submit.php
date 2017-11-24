<script id="wpoi-wizard-design_after_submit_template" type="text/template">
    
    <div class="wph-flex--side wph-flex--title">

        <h5><?php _e('After Submitting', Opt_In::TEXT_DOMAIN); ?></h5>

    </div>

    <div class="wph-flex--box">

        <label class="wph-label--alt wph-label--border"><?php _e('Choose what to do after form submission', Opt_In::TEXT_DOMAIN); ?></label>

        <div class="tabs">

            <ul class="tabs-header">

                <li {{_.add_class(on_submit === "success_message", "current" )}}>

                <label for="wpoi-on-submit-success_message">

                    <?php _e('Success Message', Opt_In::TEXT_DOMAIN); ?>

                    <input type="radio" data-attribute="on_submit" value="success_message" id="wpoi-on-submit-success_message" {{_.checked(on_submit, "success_message")}}>

                </label>

                </li>

                <li {{_.add_class(on_submit == "page_redirect", "current" )}}>

                </li>

            </ul>

            <div class="tabs-body">
                <div class="{{_.class(on_submit != "page_redirect", 'hidden')}}">
                <?php _e('Choose page to redirect to after submit', Opt_In::TEXT_DOMAIN); ?>
                <select class="wpmuiSelect" data-attribute='on_submit_page_id'>
                    <option value="0"><?php _e("Select page to redirect to", Opt_In::TEXT_DOMAIN); ?></option>
                    <# _.each( _.filter(optin_vars.pages, function(page) { return page.id !== "all" }), function(page){ #>
                        <option value="{{page.id}}" {{_.selected( on_submit_page_id.toString(), page.id.toString() )}} >{{page.text}}</option>
                    <# }); #>
                </select>
                </div>
            </div>

        </div>

    </div>
    
</script>