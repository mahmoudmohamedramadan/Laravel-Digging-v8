@component('components.book-component', ['passedData' => 'Welcome Component'])
<h4>slot text</h4>
@slot('tcustomSlot')
<h4>custom slot</h4>
@endslot
@endcomponent
