@if(request()->path() == 'admin/wizard/step-1')
<div class="steps">
	<div class="step active">1</div>
    <span class="line-status"></span>
	<div class="step">2</div>
    <span class="line-status"></span>
	<div class="step">3</div>
    <span class="line-status"></span>
	<div class="step">4</div>
</div>
@endif

@if(request()->path() == 'admin/wizard/step-2')
<div class="steps">
	<div class="step active">1</div>
    <span class="line-status active"></span>
	<div class="step active">2</div>
    <span class="line-status"></span>
	<div class="step">3</div>
    <span class="line-status"></span>
	<div class="step">4</div>
</div>
@endif

@if(request()->path() == 'admin/wizard/step-3')
<div class="steps">
	<div class="step active">1</div>
    <span class="line-status active"></span>
	<div class="step active">2</div>
    <span class="line-status active"></span>
	<div class="step active">3</div>
    <span class="line-status"></span>
	<div class="step">4</div>
</div>
@endif

@if(request()->path() == 'admin/wizard/step-4')
<div class="steps">
	<div class="step active">1</div>
    <span class="line-status active"></span>
	<div class="step active">2</div>
    <span class="line-status active"></span>
	<div class="step active">3</div>
    <span class="line-status active"></span>
	<div class="step active">4</div>
</div>
@endif
