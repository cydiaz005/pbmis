<x-app-layout>
    @section('style')
  <style>
		.card.form-locked-con{
			height: 70vh !important;
		}
		.centered-axis-xy {
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
		}
  </style>
    @endsection
    @section('content')

		@livewire('partials.content-header', [
			'pageTitle' => 'Program of Expenditures (POE)',
			'breadcrumb' => [
				['name' => 'Dashboard', 'route' => '/dashboard/admin'],
				['name' => 'Forms', 'route' => '#'],
				['name' => 'POE Form', 'route' => '/form/poe'],
				['name' => 'Edit', 'route' => '#'],
			],
		])
	<div class="card card-primary card-outline card-outline-tabs form-locked-con" style="border-top: none">
		<div class="card-body">
			<div>
				<h3>PAP: <strong>{{@$formname}}</strong> </h3>
			</div>
			<div class="centered-axis-xy">
				<div class="d-flex justify-content-center mt-5">
					<div class="no-data-label text-center" style="">
						<p class="main-label"><i class="fas fa-lock mr-2"></i>File locked</p>
						<small class="sub-label">Editor: {{@$name}}</small>
					</div>
				</div>
			</div>
			
		</div>
		<!-- /.card -->
	</div>


    @endsection
</x-app-layout>
