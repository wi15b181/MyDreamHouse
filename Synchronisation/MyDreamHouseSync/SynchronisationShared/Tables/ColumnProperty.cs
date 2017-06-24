using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationDataManager.Tables.Table;

namespace SynchronisationDataManager.Tables
{
    public class ColumnProperty
    {
        public string ColumnName { get; set; }
        public int index { get; set; }
        public DataType dataType { get; set; }
    }
}
