using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class HauspaketAttributZuord : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into hauspaket_attribut_zuord (hauspaket_id,wert_id) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, true);

            return query;
        }
    }
}
