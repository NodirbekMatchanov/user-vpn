
window.share = (variable, name) => {
	if (!name) name = variable.name;

	if (typeof name == 'string') name = [name];

	name.forEach(el => {
		window[el] = variable
	})
}