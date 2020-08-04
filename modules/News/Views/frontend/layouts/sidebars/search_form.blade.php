<div class="sidebar-widget widget_search" style="position: sticky; position: -webkit-sticky; top: 0px; z-index: 10; background-color: white;margin-bottom: 0;padding: 30px 0;">
    <form method="get" class="search" action="{{ url(app_get_locale(false,false,'/').config('news.news_route_prefix')) }}">
        <input type="text" class="form-control" value="{{ Request::query("s") }}" name="s" placeholder="{{__("Search ...")}}">
        <button type="submit" class="icon_search"></button>
    </form>
</div>