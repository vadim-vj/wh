This file describes the data set TlkAggFtrs available at https://research.yandex.com/datasets/toloka.

The data set is intended for non-commercial use. You must indicate that the data was obtained using Yandex.Toloka. If you plan to use the datasets for commercial purposes, obtain consent from Yandex by contacting: toloka@support.yandex.com. 

The task was to classify websites into 5 categories by the presence of adult content on them. The main metric of quality is accuracy of aggregated labels estimated as the fraction of the aggregated labels equal to the golden labels over the golden set. Additionally, each task has 52 real-valued features that can be used to predict its category. Workers identification, tasks information and labels names were anonymized.


Accuracy results for some aggregation models are:
	Majority Vote: 83.96%
	Dawid Skene: 69.02%
	GLAD: 84.16%

Crowdsourced labels are in the file crowd_labels.tsv, the format is:
	<worker-id>\t<task-id>\t<label>
Golden labels are in the file golden_labels.tsv, the format is:
	<task-id>\t<label>
Features for tasks are in the file features.tsv, the format is:
	<task-id>\t<feature_1>\t<feature_2>\t....<feature_52>


Some statistics about the dataset are below.
	The number of crowdsourced labels: 60572.
	The number of tasks labelled by crowdsourced workers: 1052;
 		mean workers per task: 57.58, standard deviation: 31.63;
 		median workers per task: 52.0.
	The number of workers performing the tasks: 836 ;
 		mean tasks per worker: 72.45, standard deviation: 35.25;
 		median tasks per worker: 57.0.
	The distribution of classes in crowdsourced labels:
		1: 0.11
		2: 0.07
		3: 0.5
		4: 0.06
		5: 0.26
	The number of tasks with golden labels: 991.
 	The distribution of classes in golden labels:
		1: 0.06
		2: 0.04
		3: 0.55
		4: 0.06
		5: 0.29
	Accuracy of workers:
		mean: 76.09%;
		median: 76.92%.
	Average accuracy of crowdsourced labels: 75.94%.
