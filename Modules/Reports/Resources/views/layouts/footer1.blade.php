<div style="border-top: 1px dashed lightgray" class="w3-padding" >
    <table class="table w3-border-0 text-center" >
        <tr class=" w3-border-0" >
            <td>
                <b class="w3-large" >{{ __('responsible user') }}</b>
                <br>
                <br>
                {{ Auth::user()->name }}
            </td>
            <td>
                <b class="w3-large" >{{ __('student manager') }}</b>
                <br>
                <br>
                {{ optional(Modules\Settings\Entities\TeamWork::find(2))->value }}
            </td>
            <td>
                <b class="w3-large" >{{ __('institute_manager') }}</b>
                <br>
                <br>
                {{ optional(Modules\Settings\Entities\TeamWork::find(1))->value }}
            </td>
        </tr>
    </table>
</div>