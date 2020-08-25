@extends('layouts.app')
@section('head')
	<style type="text/css">
		.bravo-contact-block .section{
			padding: 80px 0 !important;
		}

		.bravo_header.fixed-top{
			background-color: white;
		}

		.bravo_wrap .bravo_header .content .header-left .bravo-menu ul li a{
			transition: all .2s ease-out;
			color: #1a2b48;
			text-transform: none;
			font-weight: bold;
		}

		.bravo_header .content img{
			max-height: 65px;
			filter: unset;
		}

		.bravo_header .container-fluid{
			background-color: white;
			box-shadow: 1px 0 1px #1a2b48;
			/*box-shadow: 2px 3px 8px rgba(0,0,0,.1);*/
		}
	</style>
@endsection
@section('content')
<div id="bravo_content-wrapper">
	@include("Contact::frontend.blocks.contact.index")
</div>
@endsection

@section('footer')

@endsection
