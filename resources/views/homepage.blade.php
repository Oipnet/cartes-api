@extends('layout.base')

@section('content')
    <h1 class="center-align">@lang('homepage.dashboard')</h1>
    <div class="row">
        <div class="col s12 m4">
            <div class="card hoverable">
                <div class="card-content">
                    <h2 class="card-title right-align">@lang('item.count')</h2>
                    <div class="right-align" style="font-size: x-large">{{ $countItems }}</div>
                </div>
                <div class="card-action">
                    <a href="{{ route('item_index') }}">@lang('item.show')</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card hoverable">
                <div class="card-content">
                    <h2 class="card-title right-align">@lang('item.count_closed')</h2>
                    <div class="right-align" style="font-size: x-large">{{ $countClosedItems }}</div>
                </div>
                <div class="card-action">
                    <a href="{{ route('item_index', ['filter' => 'closed']) }}">@lang('item.show')</a>
                </div>
            </div>
        </div>
        <div class="row" id="selectCategories">

        </div>
    </div>
@endsection

@section('script')
    <script>
        function createSelect(categories, container, level, current) {
            const containerDiv = document.querySelector(container)

            if (!categories.length) {
                const result = document.createElement('div')
                result.classList.add('col', 's-12')
                result.innerHTML = current.id_category + ' - ' + current.name

                containerDiv.appendChild(result)
                return;
            }
            const inputField = document.createElement('div')
            inputField.classList.add('input-field','col','s12')

            const select = document.createElement('select')

            select.dataset.level = level

            const option = document.createElement('option')
            select.appendChild(option)
            categories.forEach(category => {
                const option = document.createElement('option')
                option.value = category.id_category
                option.text = category.name
                option.dataset.childrens = JSON.stringify(category.childrens)
                option.dataset.current = JSON.stringify(category)

                select.appendChild(option)
            })
            inputField.appendChild(select)

            select.addEventListener('change', (e) => {
                e.preventDefault()

                const selectedIndex = e.target.selectedIndex
                const selectedLevel = e.target.dataset.level
                const current = JSON.parse(e.target.options[selectedIndex].dataset.current)

                document.querySelectorAll('select').forEach(s => {
                    if (s.dataset.level > selectedLevel) {
                        s.parentNode.parentNode.remove(s.parentNode)
                    }
                })

                createSelect(JSON.parse(e.target.options[selectedIndex].dataset.childrens), container, level+1, current)
            })
            containerDiv.appendChild(inputField)
            M.FormSelect.init(select)
        }
        axios.get('/categories').then(response => {
            const categories = response.data.data

            createSelect(categories, '#selectCategories', 0)
        })
    </script>
@endsection