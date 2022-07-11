<?php

/* 
 *
 */

?>

customize: function ( doc ) {
<?php		
//header
//******************************************************************************
?>
		var hcols = [];
		
		hcols[0] = {
				image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAAAlCAMAAAAwXFbwAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA+tpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo1MTc2MkZFQ0QxMEUxMUU1OUU3RkRFQzI3MDg4QTlCQiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo1MTc2MkZFQkQxMEUxMUU1OUU3RkRFQzI3MDg4QTlCQiIgeG1wOkNyZWF0b3JUb29sPSJDb3JlbERSQVcgWDciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4QzRDRjlBNENGNUIxMUU1ODFCRkE1QTlGQzNFOUQ1OSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4QzRDRjlBNUNGNUIxMUU1ODFCRkE1QTlGQzNFOUQ1OSIvPiA8ZGM6Y3JlYXRvcj4gPHJkZjpTZXE+IDxyZGY6bGk+Y2hhY2FuaWNvPC9yZGY6bGk+IDwvcmRmOlNlcT4gPC9kYzpjcmVhdG9yPiA8ZGM6dGl0bGU+IDxyZGY6QWx0PiA8cmRmOmxpIHhtbDpsYW5nPSJ4LWRlZmF1bHQiPk1hbnVhbCBtYXJjYS5jZHI8L3JkZjpsaT4gPC9yZGY6QWx0PiA8L2RjOnRpdGxlPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PuX07GYAAAFWUExURcrt8h2xyPN5gzO5zf/5+uz4+kvB05Pa5Sy3zPvR1fJqdfvN0fm9wvrFytXw9Znc5kO+0ajh6vFdaoPV4fFibveeponW4nnR3mDI2Pr9/vNxfPBUYf3m6Pza3fvW2f729uX2+f3s7vrBxnDO3PaSmvrJzfBNWvm0uv7x8lrG1ye1yveiqe49TPaZoVXF1vm5viGzyaDe6Pzh5P3p6mXK2fBRXqXg6bHk7Nny9vWJkvH6+z690PJlcfWFjvz+/vze4PaVnfN2ge47SY3Y4/ittDi7z+9FU/Nueff8/felrPzc31LE1fR+iP7v8L7p73XQ3dzz9q3j6/iyuPiqsfm2vO9CUO9ATu9JVvior/zf4v3q7PivtW/N3GrM2+9GVN/0937S357e58/v80/D1P7z9PSDjP/9/vWPmP73+O48S/WHkLrn7vWLlPT7/GfL2hmwx+45SP///7vYGtkAAABydFJOU///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AHzXy+gAAAQzSURBVHja1Jn5X9owFMBBPLA4D4YnKhMVPBAVb3ROQEWnbk7n5jbPDdBtzjb//y8rbdqmyUsbrs8+e79AXtK8921eXo560P8hflkVb7J/rQUrlImCrYGnlt43FFIS3xoI0iaT0obQsWoxWycQhZE3dXH6MrMRZZQ2kFWEnjSDUj1AFEiaa+fQ+rlxBFHLF9jgVM0gCRBEWaqVY1Lvh9LuURzWa3yoFUThSK0gW1A39yRH2ecwbbH+ILv1iCwKZJsOLPTxs2VxozEgSgNAGA5NzFH5SoC8JDIbI6ubaoV/+dTZ4BnW7Ii63JstNw+eu4KsgxzEyzRBpsmW7+0dn/psac/BINZ8MgsJojJfVry1yhFiDCXe0qQox2XlAuGdl/StgFtFdZC0TAk3OmV5zwFkiVD91P7t05SPvMDkhisdWTjW/PZ+mssgDAdB0sKvA0KAUNG1w3q5Vy91wA73AiDD1sssA70y1nnapgd1yjLX299AVXdVICNEgkElTo4oAmo1Gp8Nn7pkn95bqwWyY4JAHPI9kC0MOagGJKCXi1rhhgPyAKgfjSlSHotx3JuXCBrczALRpv0iFYoyf7hYkIj7iBT5mTuG0BTMx2YrmQHZ8tzpzWaolK39v8KFQWIr7QCSEATBmxAlpVcdkm1LQL8Mhw1kXm/voac3nll/CKhtCJIxGDEC5twNBC9kcaNOz3DKCO8FgSDb1JAwINjbHsZxDghnZedkrSJUt0u8AAjEC4F8FwSZhkCuRUAmKgZB5PwBQHKqzUUapI8DQssRBNInAoKqBZG42dCMpBy7CriB9EMgdwIgZ7A7SzWC6H96oEXbGcQDgfS7g8Q5y2XBHSTEBVmwfFhnQE6cQRAEcuUGEufuxARCK+i0jR+0Cmlt8qeNYkxrHuaA+EGQAQAktq//NHVEnDbjGORXdSAL5e3EF6t8u0g/PGaA9JDy4QAJgwgej0aJAzYn7BxAtE36HGgoYuy1gOMKvG6oclQ9CN7vXjqArLj0G3vhZMhj34U0DGRIL49WD5ICbQVxZCHPjMOQ0FU/xEGaqGqBVX+FOioRcjIRkEBj+EA5qwZfF32MHVzzGesPDdItDoK37UpeX0USAiBB5hyuDtZsinzxWcqKRJ7ZK0i/reIgqPLtS9DuHHwIHoJsBDSQGXGQCuaI7QZNbPsyBL8CWhub1BUZUxPCeW1TGCRZAQg0JPOOq/4TcL/CzjLwRIYTtDDIciUgBe7VHWdBPIRdNrSzHI4Qcfd7xXB0giDrlYAgFLJbzNtTcZh7VYR3HRxeSgLUbXwriZEzrxiXk8/vCNc6x48GzINAuxSUjl3uEk172TFCPR8KSuR9ZCQflJpsD84Zz22R2nYG4wL4PpJeu+72+ZK52/p+aoq+zmTmUlU8GIhfRkuUrrRl5xir06e3fyHNRnoOn9n0fwUYAN8vUH2239wiAAAAAElFTkSuQmCC',
				width: 110,
				alignment: 'left',
				margin:[15,18,0,0]
		};
		hcols[1] = {text: '<?php echo date(Config_L::p('f_fecha_larga'),time()) ?>', alignment: 'right', margin:[0,20,20] };
		var objHeader = {};
		objHeader['alignment'] = 'center';
		objHeader['columns'] = hcols;
		doc["header"]=objHeader;
<?php		
//footer
//******************************************************************************
?>
		var fcols = [];
		fcols[0] = {text: '', alignment: 'left', margin:[20] };
		fcols[1] = {text: 'enpuntocontrol.com', alignment: 'center', margin:[0] };
		fcols[2] = {text: '', alignment: 'right', margin:[0,0,20] };
		var objFooter = {};
		objFooter['alignment'] = 'center';
		objFooter['columns'] = fcols;
		doc["footer"]=objFooter;
					
}
										
										
										