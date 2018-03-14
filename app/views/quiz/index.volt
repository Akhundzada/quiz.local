<table class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
    {% for quiz in paginator.getPaginate().items %}
        <tr>
            <td>{{ quiz.id }}</td>
            <td>{{ quiz.name }}</td>
            <td>
                {% set result = quiz.getUserScore() %}
                {% if quiz.getUserScore() == false %}
                <a href="/quiz/take/{{ quiz.id }}">Take the quiz</a>
                {% else %}
                {{ result['correct'] }}/{{ result['total'] }} ({{ result['score'] }}%)
                {% endif %}
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>
