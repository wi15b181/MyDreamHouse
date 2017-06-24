using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class Termin : Table
    {
        public Nullable<int> TerminId { get; set; }
        public Nullable<int> BenutzerId { get; set; }
        public Nullable<int> HauspaketId { get; set; }
        public string Endtime { get; set; }
        public Nullable<int> BeraterId { get; set; }
        public string Starttime { get; set; }
        public string Description { get; set; }
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (termin_id,benutzer_id,hauspaket_id,endtime,berater_id,starttime,description) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, false);
            query = AddParam(query, row, 2, DataType.NUMERIC, false);
            query = AddParam(query, row, 3, DataType.DATETIME, false);
            query = AddParam(query, row, 4, DataType.NUMERIC, false);
            query = AddParam(query, row, 5, DataType.DATETIME, false);
            query = AddParam(query, row, 6, DataType.STRING, true);

            return query;
        }

        public override string GetTableName()
        {
            return "termin";
        }

        public override string GetPrimaryKeyColumn()
        {
            return "termin_id";
        }
    }
}
