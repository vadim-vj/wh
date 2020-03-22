port=8888
path_base=/api/v1/
dir_requests=../requests/

call_endpoint() {
  local endpoint=:${port}${path_base}${1}
  local method=${2:-GET}
  local datafile=$3

  if [[ $method == "GET" ]] || [[ ! $datafile ]]; then
    http "$method" "$endpoint"

  else
    local datafile=${dir_requests}${datafile}.json
    http "$method" "$endpoint" < "$datafile"
  fi
}
