<div class="panel panel-danger">
    <div class="panel-heading">
        Report {{ ($section === 'profile') ? 'a profile' : 'a post' }}
    </div>

    <div class="panel-body">
        <form action="{{ route('report.handle') }}" method="POST">
            <div class="form-group">
                <label class="control-label">Please read this document carefully before submit a report:</label>
                <p>If you found this {{ ($section === 'profile') ? 'profile' : 'post' }} violated our <a href="#">TERMS OF SERVICE</a>, please use the form below to submit a report to the webmasters. The webmasters will look over the issues and make decisions based on it.</p>
                <p>Do not use this form to report bugs or request some fixtures, because these reports will be reviewed by the webmasters, not the developers. If you found a bug, some bugs, many bugs, or simply wanted more fixtures, contact <a href="https://github.com/trhgquan">developer's GitHub</a> or send an email to him: me*at*tranhoan.gq.</p>
                <p>Finally, <b>make sure the {{ ($section === 'profile') ? 'profile' : 'post' }} is going to be reported correctly</b>. Fake reports can make you account banned from the system.</p>
                <p>We appreciate for your contribute to making this community better!</p>
            </div>
            <div class="form-group">
                <label>
                    You are reporting this {{ ($section === 'profile') ? 'profile' : 'post' }}:  "{{ App\UserReport::participant_title($ppid, $section) }}"
                </label>
            </div>
            <div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
                <label class="control-label" for="reason">Describe more details:</label>
                <textarea class="form-control" name="reason" id="reason" placeholder="How can it violated our TERMS OF SERVICE? .." required></textarea>
                @if ($errors->has('reason'))
                    <span class="help-block">{{ $errors->first('reason') }}</span>
                @endif
            </div>
            <input type="hidden" name="ppid" value="{{ $ppid }}">
            <input type="hidden" name="section" value="{{ $section }}">
            @csrf
            <button type="submit" class="btn btn-danger">Submit this report</button>
        </form>
    </div>
</div>
