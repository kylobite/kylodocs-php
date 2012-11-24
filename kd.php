<?php
	class KyloDocs
	{

		private $path = null;

		private $file = null;

		private $dir  = null;

		private $data = array();

		function __construct($file,$path=null)
		{
			if (!empty($file))
			{
				if (empty($path))
				{
					$start = './';
					self::search($start);
					$this->file = $file;
					$this->dir = "{$this->path}/{$file}.json";

					if (!file_exists($this->dir)) self::create();	
				}
				else
				{
					
					$this->file = $file;
					$this->path = $path;
					$this->dir = "{$this->path}/{$file}.json";

					if (!file_exists($this->dir)) self::create();	
				}
			}
		}

		function __get($param)
		{
			if (isset($this->data[$param]))
			{
				return $this->data[$param];
			}
			else {
				return null;
			}
		}

		function __set($param, $value)
		{
			$this->data[$param] = $value;
		}

		function __isset($param)
		{
			return array_key_exists($param,$this->data);
		}

		function __unset($param)
		{
			unset($this->data[$param]);
		}

		function __toString()
		{
			return serialize($this->data);
		}

		function __clone()
		{
			$this->data = clone $this->data;
		}

		public function search($start)
		{
			if (empty($array))
			{
				$search = scandir($start);
				unset($search[0],$search[1]);
				$search = array_values($search);
				$found = false;
				foreach ($search as $data)
				{
					if ($data == "docs")
					{
						$this->path = $start.$data;
						$found = true;
					}
				}
				if (!$found)
				{
					foreach ($search as $data)
					{
						if (!strpos($data,'.'))
						{
							$start .= $data.'/';
							self::search($start);
						}
					}
				}
			}
		}

		public function set_array_key(&$array,$new_key,$value,$keys,$mode)
		{
			switch ($mode)
			{
				case "delete":
					foreach ($keys as $key)
					{
						$array = &$array[$key];
					}
					if ($new_key == "delete")
					{
						unset($array[$value]);
						$array = &$array;
					}
					break;
				case "array":
					if (!empty($keys))
					{
						foreach ($keys as $key)
						{
							$array = &$array[$key];
						}	
					}
					$size = (!empty($array)) ? count($array) : 0;
					$array[$size][$new_key] = $value;
					break;
				case "default":
					if (!empty($keys))
					{
						foreach ($keys as $key)
						{
							$array = &$array[$key];
						}	
					}
					$array[$new_key] = $value;
				default:
					break;
			}
		}

		public function create()
		{
			file_put_contents("{$this->dir}",json_encode(array($this->file=>null)));
		}

		public function read($string=false)
		{
			$read = json_decode(file_get_contents("{$this->dir}"),true);
			if ($string)
				return serialize($read);
			else
				return $read;
		}

		public function update($path=null,$mode="default")
		{
			$dir  = $this->dir;
			$data = $this->data;
			$json = json_decode(file_get_contents($dir),true);
			$keys = array($this->file);
			if ($path != null && $path != "*")
			{
				$path = explode('/',$path);
				foreach ($path as $p)
				{
					$keys[] = $p;
				}
			}
			foreach ($data as $k=>$v)
			{
				self::set_array_key($json,$k,$v,$keys,$mode);
			}
			$json = utf8_encode(json_encode($json));
			file_put_contents("{$dir}",$json,LOCK_EX);
			$this->data = array();
			return true;
		}

		public function delete()
		{
			unlink("{$this->dir}");
		}

		public function filter(&$array)
		{
			$data = $this->data;
			if (!is_array($array)) $array = array();
			foreach ($data as $k => $v)
			{
				$array[$k] = $v;
			}
			return serialize($array);
		}
	}